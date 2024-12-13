<?php include_once("inc/header.php"); ?>

<title>Create New Customer Account</title>

<div class="create-account-container">
  <h1>Create New Customer Account</h1>
  <h3 class="create-account-section-header">Personal Information</h3>
  <form action="traitement.php" method="post" class="create-account-form">
    <label for="username">Nom d'utilisateur: <span class="required">*</span></label>
    <input type="text" name="username" id="username" required>

    <label for="name">Prénom: <span class="required">*</span></label>
    <input type="text" name="name" id="name" required>

    <label for="lastName">Nom:<span class="required">*</span></label>
    <input type="text" name="lastName" id="lastName" required>

    <h3 class="create-account-section-header">Sign-in Information</h3>

    <label for="email">Courriel:<span class="required">*</span></label>
    <input type="email" name="email" id="email" required>

    <label for="password">Mot de passe:<span class="required">*</span></label>
    <input type="password" name="password" id="password" required>

    <label for="dateOfBirth">Date de naissance:</label>
    <input type="date" name="dateOfBirth" id="dateOfBirth" required>

    <p class="required-fields">* Required Fields</p>

    <input type="hidden" name="action" value="inscription">
    <button type="submit" class="btn create-account-submit-btn">CREATE AN ACCOUNT</button>
  </form>
</div>

<?php include_once("inc/footer.php"); ?>
