function validateForm() {
  const name = document.forms["sign-up-form"]["username"].value;
  const pwd = document.forms["sign-up-form"]["createPassword"].value;

  if (username.length < 5) {
    document.getElementsByClassName("username-error").innrHTML =
      "Please Enter username longer than 5 characters.";
  }
  if (createPassword.length < 5) {
    document.getElementsByClassName("password-error").innrHTML =
      "Please enter password longer than 5 characters.";
  }
  if (username.length < 5 || password.length < 5) {
    return false;
  }
}

/* Script doesnt seem to be affected */

/* 
const editProfile = document.querySelector(".edit-profile");

editProfile.addEventListener("click", function () {
  window.location.href = "settings.php";
});
doesnt work with session. 
 */

const hiddenForm = document.querySelector(".form.hidden");

hiddenForm.addEventListener("click", function () {
  if (hiddenForm.classList.contains("hidden")) {
    hiddenForm.classList.remove("hidden");
  } else {
    hiddenForm.classList.add("hidden");
  }
});
