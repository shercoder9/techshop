<?php include_once("inc/header.php"); ?>
<title>Sign In</title>

<div class="sign-in-container">
  <div class="sign-in-section">
    <h2 class="sign-in-title">Sign In</h2>
    <h3 class="sign-in-subtitle">REGISTERED CUSTOMERS</h3>
    <p class="sign-in-description">If you have an account, sign in with your email address.</p>

    <form action="traitement.php" method="post" class="sign-in-form">
      <label for="username">User name: <span class="required">*</span></label>
      <input type="text" name="username" id="username" required>

      <label for="mdp">Password: <span class="required">*</span></label>
      <input type="password" name="mdp" id="mdp" required>

      <div class="sign-in-show-password">
        <input type="checkbox" id="show-password">
        <label for="show-password">Show Password</label>
      </div>

      <input type="hidden" name="action" value="connexion">

      <button type="submit" class="btn sign-in-submit-btn">Sign-in</button>
    </form>
    
    <p class="required-fields">* Required Fields</p>
  </div>

  <div class="sign-in-new-customers">
    <h3 class="new-customers-title">NEW CUSTOMERS</h3>
    <p class="new-customers-description">
      Creating an account has many benefits: check out faster, keep more than one address, track orders and more.
    </p>
    <button class="btn new-customers-btn" onclick="location.href='register.php'" type="button">CREATE ACCOUNT</button>
  </div>
</div>

<?php include_once("inc/footer.php"); ?>
