<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bug App Deep Linking</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- Override Bootstrap Primary Color -->
  <style>
    :root {
      --bs-primary: rgb(17, 28, 67);
    }
  </style>
</head>
<body>
  
  <!-- Bootstrap Modal -->
  <div class="modal fade" id="appModal" tabindex="-1" aria-labelledby="appModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0">
          <img src="https://xbug.online/assets/images/logo.png" alt="Logo" class="img-fluid" style="height: 50px;">
        </div>
        <div class="modal-body">
          <div class="card text-center border-0">
            <div class="card-body">
              <i class="bi bi-app-indicator" style="font-size: 3rem; color: var(--bs-primary);"></i>
              <h5 class="card-title mt-3">Fill your attendance</h5>
              <div class="d-grid gap-3 mt-4">
                <button id="continueWithAppBtn" style="background-color: var(--bs-primary);" class="btn btn-lg rounded-pill d-flex align-items-center justify-content-center text-white">
                  <i class="bi bi-phone me-2"></i> Continue with App
                </button>
                <button id="continueAsGuestBtn" class="btn btn-outline-primary btn-lg rounded-pill d-flex align-items-center justify-content-center">
                  <i class="bi bi-person me-2"></i> Continue as Guest
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies (Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    class DeepLinker {
      static openFlutterApp() {
        // Detect Android device
        const isAndroid = /Android/i.test(navigator.userAgent);

        if (isAndroid) {
          console.log('Android device detected. Displaying options...');
          // Show the Bootstrap modal for the user to choose an option
          const appModal = new bootstrap.Modal(document.getElementById('appModal'));
          appModal.show();
        } else {
          console.log('Not an Android device');
          const currentUrl = window.location.href;

          // Extract the card_id from the URL
          const urlParts = currentUrl.split('/');
          const cardId = urlParts[urlParts.length - 1];
          window.location.href = `/guest/${cardId}`;  // Redirect to guest page if not an Android device
        }
      }

      // Method to open the app using a custom scheme
      static tryOpenAppWithScheme() {
        try {
          // Custom URL scheme for your app
          const appScheme = 'bug://open';
          
          // Attempt to open the app
          window.location.href = appScheme;

          // Show the Play Store link after 3 seconds if the app doesn't open
          setTimeout(() => {
            if (!document.hidden) {
              // App was not opened, fallback to Play Store
              window.location.href = 'https://play.google.com/store/apps/details?id=com.bug.build_growth_mobile';
            }
          }, 3000); // Timeout after 3 seconds
        } catch (error) {
          console.error('Scheme opening failed:', error);
        }
      }
    }

    // Event listeners for buttons after DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
      // Automatically try to show the dialog once the page loads
      DeepLinker.openFlutterApp();

      // Handle the "Continue with App" button
      document.getElementById('continueWithAppBtn').addEventListener('click', function() {
        // Hide the modal
        const appModalElement = document.getElementById('appModal');
        const appModal = bootstrap.Modal.getInstance(appModalElement);
        appModal.hide();

        // Try to open the app
        DeepLinker.tryOpenAppWithScheme();
      });

      // Handle the "Continue as Guest" button
      document.getElementById('continueAsGuestBtn').addEventListener('click', function() {
        const currentUrl = window.location.href;

        // Extract the card_id from the URL
        const urlParts = currentUrl.split('/');
        const cardId = urlParts[urlParts.length - 1];
        window.location.href = `/guest/${cardId}`;  // Redirect to guest page
      });
    });
  </script>
</body>
</html>
