<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bug App Deep Linking</title>
  <style>
    /* Style for the dialog */
    .dialog {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    .dialog-content {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
    }
    .dialog button {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  

  <!-- Dialog HTML -->
  <div id="dialog" class="dialog">
    <div class="dialog-content">
    logo
      <p>Fill your attendance</p>
      <button id="continueWithAppBtn">Continue with app</button>
      <button id="continueAsGuestBtn">Continue as guest</button>
    </div>
  </div>

  <script>
    class DeepLinker {
      static openFlutterApp() {
        // Detect Android device
        const isAndroid = /Android/i.test(navigator.userAgent);

        if (isAndroid) {
          console.log('Android device detected. Displaying options...');
          // Show the dialog for the user to choose an option
          this.showDialog();
        } else {
          console.log('Not an Android device');
          const currentUrl = window.location.href;

// Extract the card_id from the URL
          const urlParts = currentUrl.split('/');
          const cardId = urlParts[urlParts.length - 1];
          window.location.href = `/guest/${cardId}`;  // Redirect to guest page if not an Android device
        }
      }

      // Show dialog to let the user choose between opening the app or continuing as guest
      static showDialog() {
        const dialog = document.getElementById('dialog');
        dialog.style.display = 'flex';

        // Handle the "Continue with app" button
        document.getElementById('continueWithAppBtn').onclick = function() {
          DeepLinker.tryOpenAppWithScheme();
        };

        // Handle the "Continue as guest" button
        document.getElementById('continueAsGuestBtn').onclick = function() {
          const currentUrl = window.location.href;

// Extract the card_id from the URL
          const urlParts = currentUrl.split('/');
          const cardId = urlParts[urlParts.length - 1];
          window.location.href = `/guest/${cardId}`;  // Redirect to guest page
        };
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
          }, 300); // Timeout after 3 seconds
        } catch (error) {
          console.error('Scheme opening failed:', error);
        }
      }
    }

    // Automatically try to show the dialog once the page loads
    window.onload = function() {
      DeepLinker.openFlutterApp();
    };
  </script>
</body>
</html>
