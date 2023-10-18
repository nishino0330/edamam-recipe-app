<!DOCTYPE html>
<html>
<head>
    <title>Recipe Search</title>
</head>
<body>
    <h1>Recipe Search</h1>
    <form action="/search" method="GET">
        <label for="ingredients">Ingredients:</label>
        <input type="text" name="ingredients" id="ingredients">
        
        <input type="checkbox" id="japanese" name="japanese" />
        <label for="japanese">japanese</label>
        <button type="submit">Search</button>
    </form>

    @if(isset($recipes))
        <h2>Search Results:</h2>
        @if(count($recipes) > 0)
            <ul>
                @foreach($recipes as $recipe)
                    <!--料理名と画像を表示 -->
                    <li>{{ $recipe['recipe']['label'] }}</li>
                    <img src="{{ $recipe['recipe']['image'] }}" alt="{{ $recipe['recipe']['label'] }}">

                    <!-- 料理の作り方を表示 -->
                    @foreach($recipe['recipe']['ingredientLines'] as $step)
                        <li>{{ $step }}</li>
                    @endforeach
                @endforeach
            </ul>
        @else
            <p>No recipes found.</p>
        @endif
    @endif
</body>
</html>
