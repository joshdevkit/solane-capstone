document.addEventListener('DOMContentLoaded', function () {
    // Select all dropdown buttons, arrows, and their corresponding dropdowns
    const buttons = document.querySelectorAll('.dropdown-button');
    const arrows = document.querySelectorAll('.arrow');
    const dropdownMenus = document.querySelectorAll('.dropdown-content');

    // Function to show the dropdown
    function showDropdown(dropdown) {
        dropdown.style.display = 'block';
    }

    // Function to hide the dropdown
    function hideDropdown(dropdown) {
        dropdown.style.display = 'none';
    }

    // Add event listeners for each button and arrow
    buttons.forEach((button, index) => {
        const dropdown = dropdownMenus[index];

        // Show dropdown on mouseover (button or arrow)
        button.addEventListener('mouseover', function () {
            showDropdown(dropdown);
        });

        arrows[index].addEventListener('mouseover', function () {
            showDropdown(dropdown);
        });

        // Hide dropdown when the mouse leaves the button or arrow, unless it's over the dropdown itself
        button.addEventListener('mouseout', function () {
            setTimeout(() => {
                if (!dropdown.matches(':hover')) {
                    hideDropdown(dropdown);
                }
            }, 200); // Delay to allow hover over dropdown
        });

        arrows[index].addEventListener('mouseout', function () {
            setTimeout(() => {
                if (!dropdown.matches(':hover')) {
                    hideDropdown(dropdown);
                }
            }, 200);
        });

        // Keep the dropdown visible when hovering over the dropdown content
        dropdown.addEventListener('mouseover', function () {
            showDropdown(dropdown);
        });

        // Hide dropdown when the mouse leaves the dropdown content
        dropdown.addEventListener('mouseout', function () {
            hideDropdown(dropdown);
        });
    });

    // Handle clicks outside the dropdowns to close them
    document.addEventListener('click', function (event) {
        dropdownMenus.forEach(dropdown => {
            if (!event.target.closest('.dropdown-button, .dropdown-content, .arrow')) {
                hideDropdown(dropdown);
            }
        });
    });

    // Handle dropdown item clicks and update button text
    const dropdownItems = document.querySelectorAll('.dropdown-content li');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function () {
            const parentDropdown = this.closest('.thismonth');
            const button = parentDropdown.querySelector('.dropdown-button');
            button.textContent = this.textContent;
            parentDropdown.querySelector('.dropdown-content').style.display = 'none';
        });
    });
});
