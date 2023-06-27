document.addEventListener("DOMContentLoaded", function () {
  

  
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    const submitButton = form.querySelector('button[type="submit"]');
    const requiredInputs = form.querySelectorAll(
      "input[required], textarea[required]"
    );
    requiredInputs.forEach((input) => {
      input.addEventListener("input", () => {
        const isFormValid = Array.from(requiredInputs).every((input) =>
          input.checkValidity()
        );
        submitButton.disabled = !isFormValid;
      });
    });
  });
});
