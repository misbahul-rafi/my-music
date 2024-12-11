<div id="process" class="absolute top-4 right-3 bg-green-500 w-44 justify-center gap-3 py-2 flex text-title rounded-lg">
  <p>{{$message}}</p>
  <i class="bi bi-check2-circle"></i>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let processDiv = document.getElementById('process');
    if (processDiv) {
      setTimeout(function() {
        processDiv.style.display = 'none';
      }, 3000); // Hide after 3 seconds
    }
  });
</script>
