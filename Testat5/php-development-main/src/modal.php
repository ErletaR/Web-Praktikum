<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>modal</title>
</head>
<body>
<h1>modal</h1>
<div class="input-group m-3">
<input class="form-control" id="someText">
<button type="button" class="btn btn-primary" id="button">Primary </button>
</div>
<div class="modal" tabindex="-1" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id = "save">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
var myModal = new bootstrap.Modal(document.getElementById('myModal'));
myModal.show();
document.getElementById("button").addEventListener("click", myFunction);
function myFunction() {
  var inputField = document.getElementById('someText');
  var myModalElement = document.getElementById('myModal');
myModalElement.querySelector('.modal-body').innerHTML =
`<p>${inputField.value}</p>`;
  myModal.show();
}
document.getElementById("save").addEventListener("click", save);
function save(){
  console.log("bla");
  myModal.hide();
}
  </script>
</body>
</html>











