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

    //allow user to change document title and reassign admin of document on edit doc page
    const docTitleInput   = document.getElementById("doc_title_input");
    const changeDocForm    = document.getElementById("change_title_form");

    const docAdminInput   = document.getElementById("new_admin_input");
    const changeAdminForm    = document.getElementById("change_admin_form");

    const docTitleDisplay = document.getElementById("doc_title_display");
    const changeDocButton = document.getElementById("change_document_button");

    if(changeDocButton && docTitleDisplay){
        changeDocButton.addEventListener("click", function(event) {
            event.preventDefault();
            if (docTitleDisplay.style.display === "block") {
                docTitleDisplay.style.display = "none";
            } else {
                docTitleDisplay.style.display = "block";
            }
        });
        if(docTitleInput && changeDocForm){
            changeDocButton.addEventListener("click", function(event) {
                event.preventDefault();
                if (changeDocForm.style.display === "block") {
                    changeDocForm.style.display = "none";
                } else {
                    changeDocForm.style.display = "block";
                }
                docTitleInput.focus();
            });

            docTitleInput.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                event.preventDefault();
                changeDocForm.submit();
                }
            });
        }

        if(docAdminInput && changeAdminForm){
            changeDocButton.addEventListener("click", function(event) {
                event.preventDefault();
                if (changeAdminForm.style.display === "block") {
                    changeAdminForm.style.display = "none";
                } else {
                    changeAdminForm.style.display = "block";
                }
            });

            docAdminInput.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                event.preventDefault();
                changeAdminForm.submit();
                }
            });
        }

    }

    //allow admin to ch.addEventListenersection title and assigned user on edit doc page
    const sectionTitleInput   = document.getElementById("section_title_input");
    const sectionTitleForm    = document.getElementById("change_section_title_form");
    const assignedUserInput   = document.getElementById("section_user_input");
    const assignedUserForm    = document.getElementById("change_user_form");

    const changeSectionButton = document.getElementById("change_section_button");

    if(changeSectionButton){
        if(sectionTitleInput && sectionTitleForm){
            changeSectionButton.addEventListener("click", function(event) {
                event.preventDefault();
                if (sectionTitleForm.style.display === "block") {
                    sectionTitleForm.style.display = "none";
                } else {
                    sectionTitleForm.style.display = "block";
                }
                sectionTitleInput.focus();
            });

            sectionTitleInput.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                event.preventDefault();
                sectionTitleForm.submit();
                }
            });
        }

        if(assignedUserInput && assignedUserForm){
            changeSectionButton.addEventListener("click", function(event) {
                event.preventDefault();
                if (assignedUserForm.style.display === "block") {
                    assignedUserForm.style.display = "none";
                } else {
                    assignedUserForm.style.display = "block";
                }
                assignedUserInput.focus();
            });

            assignedUserInput.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                event.preventDefault();
                assignedUserForm.submit();
                }
            });
        }
    }

    //allows user to change full name on profile page
    const nameInput = document.getElementById("full_name_text_input");
    const nameForm  = document.getElementById("name_change_form");

    if(nameInput && nameForm){
        nameInput.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
            event.preventDefault();
            nameForm.submit();
            }
        });
    }

    //For uploading user profile picture
    const userProfPic = document.getElementById("user_prof_pic");
    const userProfPicForm = document.getElementById("user_prof_pic_form");

    if(userProfPic){
        userProfPic.addEventListener("change", function(event) {
            event.preventDefault();
            userProfPicForm.submit();
        });
    }

    //For creating new sections
    const sectionContainer    = document.querySelector('.sectionContainer');
    const createSectionButton = document.getElementById('create_section_button');
    let sectionCount          = 1;

    //create section functionality
    if(createSectionButton){
        createSectionButton.addEventListener('click', function(e) {
            e.preventDefault();
            const originalSection = sectionContainer.querySelector('.section');
            const newSection = originalSection.cloneNode(true);

            //update IDs and names of inputs and h3 in each new section
            newSection.querySelectorAll('input').forEach(function(input) {
                const originalId   = input.getAttribute('id');
                const originalName = input.getAttribute('name');
                input.setAttribute('id', `${originalId.slice(0, -1)}${sectionCount + 1}`);
                input.setAttribute('name', `${originalName.slice(0, -2)}${sectionCount}]`);
                input.value = '';
            });
            
            newSection.querySelector('h3').setAttribute('id', `title_assign_section${sectionCount + 1}`);
            newSection.querySelector('h3').textContent = `Section ${sectionCount + 1}`;

            sectionContainer.appendChild(newSection);
            sectionCount++;
            updateDeleteButtonVisibility();
        });
    }

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