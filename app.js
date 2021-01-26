/* Fills no function right now */
/*

const hiddenForm = document.querySelector(".form.hidden");
const editButton = document.querySelector(".edit-post");

editButton.addEventListener("click", function () {
  if (hiddenForm.classList.contains("hidden")) {
    hiddenForm.classList.remove("hidden");
  } else {
    hiddenForm.classList.add("hidden");
  }
});
*/
const deleteAccountBtn = document.querySelector("#delete-account-btn");
if (deleteAccountBtn) {
  deleteAccountBtn.addEventListener("click", (e) => {
    e.preventDefault();
    const confirm = window.confirm("You are now deleting your account");
    if (confirm) {
      document.querySelector("#delete-account-form").submit();
    }
  });
}
