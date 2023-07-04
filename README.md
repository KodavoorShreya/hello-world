# hello-world
Hey!!It's ma first repository on GitHub :D

# Trying explore github in-dept 
# sample html code just to try
<!DOCTYPE html>
<html>
<head>
  <title>GitHub README Explorer</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    .readme-content {
      max-width: 800px;
      margin: 0 auto;
    }
  </style>
</head>
<body>
  <div class="readme-content">
    <h1>GitHub README Explorer</h1>
    <div id="readme"></div>
  </div>

  <script>
    // Fetch the README file from GitHub API
    fetch('https://api.github.com/repos/{Kodavoor Shreya}/{hello-world}/readme')
      .then(response => response.json())
      .then(data => {
        // Base64 decode the content
        const readmeContent = atob(data.content);

        // Set the content in the 'readme' div
        document.getElementById('readme').innerHTML = readmeContent;
      })
      .catch(error => {
        console.error('Error:', error);
        document.getElementById('readme').innerHTML = 'Failed to fetch the README file.';
      });
  </script>
</body>
</html>
