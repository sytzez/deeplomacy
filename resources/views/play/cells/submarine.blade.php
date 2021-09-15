<a href="javascript:void(0)" onclick="this.parent.querySelector('options').hidden = ! this.parent.querySelector('options').hidden">
    🚢
</a>
<div class="options">
    <form method="post" action="{{ route('play.attack', [$game]) }}">
        @csrf

        <input type="hidden" name="submarine" value="{{ $cell->getSubmarine()->getModel()->id }}">
        <input type="submit" value="Attack">

    </form>

    <form method="post" action="{{ route('play.share-sonar', [$game]) }}">
        @csrf

        <input type="hidden" name="submarine" value="{{ $cell->getSubmarine()->getModel()->id }}">
        <input type="submit" value="Share sonar">

    </form>

    <form method="post" action="{{ route('play.give-action-points', [$game]) }}">
        @csrf

        <input type="hidden" name="submarine" value="{{ $cell->getSubmarine()->getModel()->id }}">
        <label for="amount">AP:</label>
        <input type="number" name="amount" id="amount" min="1" max="{{ $mySubmarine->getActionPoints()->getAmount() }}">
        <input type="submit" value="Give AP">

    </form>
</div>
