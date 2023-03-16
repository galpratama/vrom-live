// Navbar Toggler
$(".mobileMenuButton").each(function (_, navToggler) {
    var target = $(navToggler).data("target");
    $(navToggler).on("click", function () {
        $(target).animate({
            height: "toggle",
        });
    });
});

// FAQ
var buttonFaq = document.querySelectorAll(".accordion");
for (let index = 0; index < buttonFaq.length; index++) {
    buttonFaq[index].addEventListener("click", (e) => {
        e.preventDefault();
        var idButton = e.currentTarget.getAttribute("id");
        var faqContent = document.querySelector(`#${idButton}-content`);
        // Toggle faq content
        faqContent.classList.toggle("hidden");
        // Rotate arrow
        document
            .querySelector(`#${idButton} img`)
            .classList.toggle("rotate-180");
    });
}

// Toggle Dropdown
function toggleDropdown(el) {
    document.getElementById("userDropdownMenu").classList.toggle("hidden");
}

// Upload user photo
$("#btnUploadPhoto").on("click", () => {
    $("input#photo").trigger("click");
});

// Delete photo preview
$("#btnDeletePhoto").on("click", () => {
    $("#imageSrc").attr("src", "../assets/svgs/ic-default-photo.svg");
    $("#btnDeletePhoto").toggleClass("hidden");
    $("#btnUploadPhoto").toggleClass("hidden");
});

// Show photo preview
$("#photo").change(function (e) {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#imageSrc").attr("src", e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }

    $("#btnDeletePhoto").toggleClass("hidden");
    $("#btnUploadPhoto").toggleClass("hidden");
});
