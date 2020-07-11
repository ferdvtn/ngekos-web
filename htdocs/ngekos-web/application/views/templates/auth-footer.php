<script src=<?= BASE_URL("assets/vendor/popper.js") ?>></script>
<script src=<?= BASE_URL("assets/vendor/bootstrap/js/bootstrap.min.js") ?>></script>
<!-- Optional JavaScript -->
<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>
</body>

</html>