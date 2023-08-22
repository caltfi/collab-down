        <footer class="d-flex justify-content-end align-items-center bg-light p-3" style="position: absolute; bottom: 0; right: 0; border-top: 2px solid #e9ecef;">
          <a href="" class="text-body small me-3">About</a>
          <a href="" class="text-body small me-3">Github</a>
          <span class="small text-muted ps-4">2023  Calum Fenton</span>
        </footer>
    </main>
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
    </script>
</body>
</html>