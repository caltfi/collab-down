document.addEventListener("DOMContentLoaded", function() {

    //displays cheat sheet on click of link on navbar
    const cheatSheetLink = document.getElementById("cheat_sheet_link");
    const cheatSheet = document.getElementById("cheat_sheet");

    cheatSheetLink.addEventListener("click", function(event) {
        event.preventDefault();
        if (cheatSheet.style.display === "block") {
            cheatSheet.style.display = "none";
        } else {
            cheatSheet.style.display = "block";
        }
    });

    //allow user to create new doc form on navbar
    const newDocButton = document.getElementById("new_doc_button");
    const titleInput   = document.getElementById("title_text_input");
    const newDocForm   = document.getElementById("new_doc_form");

    newDocButton.addEventListener("click", function(event) {
        event.preventDefault();
        if (newDocForm.style.display === "block") {
            newDocForm.style.display = "none";
        } else {
            newDocForm.style.display = "block";
        }
        titleInput.focus();
    });

    titleInput.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
        event.preventDefault();
        newDocForm.submit();
        }
    });

    //allow user to create new doc form on main index page
    const newDocButton2 = document.getElementById("new_doc_main_button");
    const titleInput2   = document.getElementById("title_text_input_2");
    const newDocForm2   = document.getElementById("new_doc_form_2");

    if(newDocButton2 && titleInput2 && newDocForm2){
        newDocButton2.addEventListener("click", function(event) {
            event.preventDefault();
            if (newDocForm2.style.display === "block") {
                newDocForm2.style.display = "none";
            } else {
                newDocForm2.style.display = "block";
            }
            titleInput2.focus();
        });

        titleInput2.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
            event.preventDefault();
            newDocForm2.submit();
            }
        });
    }

    //For creating new sections in edit_document.php
    const sectionContainer = document.querySelector('.sectionContainer');
    let sectionCount       = 1;
    //create section functionality
    document.getElementById('create_section_button').addEventListener('click', function(e) {
        e.preventDefault();
        const originalSection = sectionContainer.querySelector('.section');
        const newSection = originalSection.cloneNode(true);

        //update IDs and names of inputs and h3 in each new section
        newSection.querySelectorAll('input').forEach(function(input) {
            const originalId   = input.getAttribute('id');
            const originalName = input.getAttribute('name');
            input.setAttribute('id', `${originalId.slice(0, -1)}${sectionCount + 1}`);
            input.setAttribute('name', `${originalName.slice(0, -1)}${sectionCount + 1}`);
            input.value = '';
        });
        newSection.querySelector('h3').textContent = `Section ${sectionCount + 1}`;

        sectionContainer.appendChild(newSection);
        sectionCount++;
        updateDeleteButtonVisibility();
    });

    //delete section functionality
    sectionContainer.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('delete-section-button')) {
            const sections = sectionContainer.querySelectorAll('.section');
            if (sections.length > 1) {
                sectionContainer.removeChild(sections[sections.length - 1]);
                sectionCount--;
                updateDeleteButtonVisibility();
            }
        }
    });

    //delete section button visibility
    function updateDeleteButtonVisibility() {
        const deleteButtons = sectionContainer.querySelectorAll('.delete-section-button');
        deleteButtons.forEach(function(deleteButton) {
            deleteButton.style.display = 'none';
        });
        const lastDeleteButton = sectionContainer.lastElementChild.querySelector('.delete-section-button');
        const sections = sectionContainer.querySelectorAll('.section');
        if(lastDeleteButton && sections.length !== 1){
            lastDeleteButton.style.display = 'block';
        }
    }

    updateDeleteButtonVisibility();
});