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
</div>
