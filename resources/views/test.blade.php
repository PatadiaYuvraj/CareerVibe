<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Test</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
    <form action="{{ route('testing') }}" method="post" id="myForm">
        @csrf
        <div id="container" data-total="1">
            <input type="text" class="name-input" name="name[]" id="name-1" placeholder="Name" />
            <span class="name-error"></span>

        </div>
        <br />
        <button type="button" id="add">Add</button>
        <br />
        <input type="button" id="submit" name="submit" value="Submit" />

    </form>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        var fieldCount = 1;

        $("#add").click(function() {
            fieldCount++;
            $("#container").append(
                '<div><input type="text" class="name-input" name="name[]" id="name-' + fieldCount +
                '" placeholder="Name" /><span class="name-error"></span><button type="button" id="remove-' +
                fieldCount + '">remove</button></div>'
            );
            $("#container").attr("data-total", fieldCount);
        });

        $("#container").on("click", "button[id^='remove-']", function() {
            fieldCount--;
            $("#container").attr("data-total", fieldCount);
            $(this).parent().remove();
        });
    });
</script>

</html>
