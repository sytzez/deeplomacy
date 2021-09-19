<?php

namespace App\Http\Resources;

use App\Adapters\SubmarineAdapter;
use App\Game\Contracts\SubmarineContract;
use App\Game\Data\Cell;
use App\Models\Submarine;
use DomainException;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @return array<array<Cell>>
 * @method getRows()
 */
class GridResource extends JsonResource
{
    public function toArray($request): array
    {
        $array = [];

        foreach ($this->getRows() as $row) {
            $arrayRow = [];

            foreach ($row as $cell) {
                $arrayRow[] = $this->cellToArray($cell);
            }

            $array[] = $arrayRow;
        }

        return $array;
    }

    public function cellToArray(Cell $cell): array
    {
        return [
            'x'                   => $cell->getPosition()->getX(),
            'y'                   => $cell->getPosition()->getY(),
            'isVisible'           => $cell->isVisible(),
            'canMoveTowards'      => $cell->canMoveTowards(),
            'submarine'           => $cell->getSubmarine()
                ? $this->submarineToArray($cell->getSubmarine())
                : null,
            'canAttack'           => $cell->canAttack(),
            'canShareSonar'       => $cell->canShareSonar(),
            'canGiveActionPoints' => $cell->canGiveActionPoints(),
        ];
    }

    public function submarineToArray(SubmarineContract $submarine): array
    {
        if (! $submarine instanceof SubmarineAdapter) {
            throw new DomainException();
        }

        $submarineModel = $submarine->getModel();

        return [
            'id'   => $submarineModel->getKey(),
            'name' => $submarineModel->user->name,
        ];
    }
}
