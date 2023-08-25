        <footer class="d-flex justify-content-end align-items-center bg-light p-3" style="position: absolute; bottom: 0; right: 0; border-top: 2px solid #e9ecef; height: 72px; width:100vw; z-index:1;">
            <section class="align-content-center">
            <a href="#" class="text-body small me-2">About</a> 
            <a href="https://github.com/caltfi/collab-down" class="text-body small me-2">GitHub</a>
            <a href="#" class="text-body small">Privacy</a>
            <span class="small text-muted ps-4">2023 Calum Fenton</span>
            </section>
        </footer>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
        });

        //allow user to create new doc form on navbar
        document.addEventListener("DOMContentLoaded", function() {
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
        });
    </script>
</body>
</html>