<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
        .item-wrapper {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(6, 150px);
            grid-auto-rows: 150px;
            grid-auto-flow: dense;
        }

        .item {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item button {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .active {
            grid-column: auto / span 2;
            grid-row: auto / span 2;
        }
    </style>
</head>
<body>
<div class="item-wrapper">
</div>

@if(Auth::check() && Auth::user()->role == "admin")
    <form onsubmit="addImage(event)">
        <input multiple name="images" type="file">
        <button>추가하기</button>
    </form>
@endif

<script src="{{ asset('js/gallary.js') }}"></script>
</body>
</html>
