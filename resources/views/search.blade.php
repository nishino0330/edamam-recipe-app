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
        <button type="submit">Search</button>
    </form>

    @if(isset($recipes))
        <h2>Search Results:</h2>
        @if(count($recipes) > 0)
            <ul>
                @foreach($recipes as $recipe)
                    <li>{{ $recipe['recipe']['label'] }}</li>
                @endforeach
            </ul>
        @else
            <p>No recipes found.</p>
        @endif
    @endif
</body>
</html>
