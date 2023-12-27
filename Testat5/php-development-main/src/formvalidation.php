<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>modal</title>
</head>
<body>
<form>
<div class="form-floating mb-3">
<input type="number" class="form-control" id="floatingInput" onkeyup="keyup(this)"
placeholder="enter integer">
<label for="floatingInput">Some Integer</label>
<div class="valid-feedback">
Looks good!
</div>
<div class="invalid-feedback">
Try again...
</div>
</div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    function keyup(input){
        input.classList.remove("is-valid", "is-invalid");

        if (input.value=="42"){
            input.classList.add("is-valid");
        }else{
            input.classList.add("is-invalid");
        } 
    }

  </script>
</body>
</html>
