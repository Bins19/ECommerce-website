<?php
$title = 'Payer';
ob_start();
?>
<div class="container">
    <h4>Entrez-vous vos coordonnées bancaires !</h4>
    <form action="index.php?action=pay" method="post" class="needs-validation" novalidate>
        <div class="form-row">
            <div class="form-group col-9">
                <label for="nmrCard">Numéro carte</label>
                <input type="text" class="form-control" id="nmrCard" name="nmrCard" required>
                <div class="invalid-feedback">
                    Entrer svp un numéro de carte
                </div>
            </div>
            <div class="form-group col-3">
                <label for="check">Code de vérification</label>
                <input type="text" class="form-control" id="check" name="check" required>
                <div class="invalid-feedback">
                    Insérer svp un code de vérification
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="date">Date d'expiration</label>
            <div class="row">
                <div class="col">
                    <select name="month" id="month" class="custom-select" required>
                        <option selected disabled value="">Mois</option>
                        <option value="01">Janvier</option>
                        <option value="02">Février</option>
                        <option value="03">Mars</option>
                        <option value="04">Avril</option>
                        <option value="05">Mai</option>
                        <option value="06">Juin</option>
                        <option value="07">Juillet</option>
                        <option value="08">Août</option>
                        <option value="09">Septembre</option>
                        <option value="10">Octobre</option>
                        <option value="11">Novembre</option>
                        <option value="12">Décembre</option>
                    </select>
                    <div class="invalid-feedback">
                        Entrer un mois svp
                    </div>
                </div>
                <div class="col">
                    <select name="year" id="year" class="custom-select" required>
                        <option selected disabled value="">Année</option>
                        <?php
                        $currentYear = date('Y');
                        for($i = 0; $i < 10; $i ++) {
                            ?>
                            <option value="<?= $i+$currentYear ?>"><?= $i+$currentYear ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        Entrer une année svp
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-success">Payer</button>
    </form>
</div>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<?php
$content = ob_get_clean();
require('template.php');