
<div class="container text-center">
  <div class="row mt-3">
    <div class="col-4">
    </div>
    <div class="col-4">
    <h1><?= $data['title']; ?></h1>
    </div>
    <div class="col-4">
    </div>
  </div>

            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                <form class="row g-3" method="post" action="<?= URLROOT; ?>/Register/index">
                    <div class="col-md-12">
                        <label for="inputEmail" class="form-label">E-mail</label>
                        <input name= "email" type="email" class="form-control" id="inputEmail">
                    </div>
                    <div class="col-12">
                        <label for="inputFirstname" class="form-label">Voornaam</label>
                        <input name="firstname" type="text" class="form-control" id="inputFirstname" >
                    </div>
                    <div class="col-12">
                        <label for="inputInfix" class="form-label">Tussenvoegsel</label>
                        <input name="infix" type="text" class="form-control" id="inputInfix" >
                    </div>
                    <div class="col-12">
                        <label for ="inputLastname" class="form-label">Achternaam</label>
                        <input name="lastname" type="text" class="form-control" id="inputLastname" >
                    </div>
                    <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="Submit">Button</button>   
                    </div>
                </form>
    </div>
    <div class="col-3"></div>
  </div>
</div>


