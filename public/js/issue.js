document.addEventListener("DOMContentLoaded", function () {
    const dropdowns = document.querySelectorAll(".dropdown-toggle");
    const closeButtons = document.querySelectorAll(".close-dropdown");

    dropdowns.forEach((dropdown) => {
        dropdown.addEventListener("click", function (event) {
            event.preventDefault();
            const dropdownMenu = this.nextElementSibling;
            const isOpen = dropdownMenu.classList.contains("show");
            const issueWrapper = this.closest(".issue-wrapper");
            const nextIssueWrapper = issueWrapper.nextElementSibling;

            // Close all dropdowns
            document.querySelectorAll(".dropdown-menu").forEach((el) => {
                el.classList.remove("show");
            });

            // Reset all issue wrapper margins
            document.querySelectorAll(".issue-wrapper").forEach((el) => {
                el.style.marginBottom = "20px";
            });

            if (!isOpen) {
                dropdownMenu.classList.add("show");
                if (nextIssueWrapper) {
                    const height = dropdownMenu.scrollHeight;
                    issueWrapper.style.marginBottom = `${height + 20}px`;
                }
            }

            // Toggle dropdown arrow
            this.classList.toggle("open");
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", function (event) {
            event.stopPropagation();
            const dropdownMenu = this.closest(".dropdown-menu");
            dropdownMenu.classList.remove("show");
            const issueWrapper = dropdownMenu.closest(".issue-wrapper");
            issueWrapper.style.marginBottom = "20px";
            issueWrapper
                .querySelector(".dropdown-toggle")
                .classList.remove("open");
        });
    });
});
