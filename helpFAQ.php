<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chatbot</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="style.css">
    <style>
        /* Chat Container */
        #chat-container {
            width: 700px;
            height: 500px;
            border: 1px solid #ccc;
            padding: 10px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        #chatbox {
            height: 400px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            padding: 10px;
        }

        /* Speech Bubbles */
        .userText, .botText {
            display: flex;
            align-items: center;
            margin: 8px 0;
            max-width: 75%;
            padding: 10px 15px;
            border-radius: 20px;
            font-size: 16px;
        }

        .userText {
            align-self: flex-end;
            background-color: lightblue;
            text-align: right;
            position: relative;
        }

        .userText::after {
            content: "";
            position: absolute;
            bottom: 0;
            right: -10px;
            width: 0;
            height: 0;
            border-left: 10px solid lightblue;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
        }

        .botText {
            align-self: flex-start;
            background-color: lightgray;
            text-align: left;
            position: relative;
        }

        .botText::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: -10px;
            width: 0;
            height: 0;
            border-right: 10px solid lightgray;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
        }

        /* Profile Icons */
        .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 5px;
            display: inline-block;
            text-align: center;
            font-size: 24px;
            line-height: 40px;
            background-color: #ddd;
        }

        .user-message {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .bot-message {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
        
        /* Adjusting input field and button to match chat width */
    #userInput {
        width: 75%; /* Adjust width dynamically */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
        font-size: 16px;
        outline: none;
    }

    button {
        width: 20%; /* Adjusted to fit beside the input field */
        padding: 10px;
        border: none;
        border-radius: 20px;
        background-color: red;
        color: white;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background-color: darkred;
    }

    /* Aligning input and button */
    .chat-input-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%; /* Matches chat width */
        margin-top: 10px;
    }
    </style>
</head>
<body>

    <!-- Navigation -->
  <div class="navbar">
    <div class="logo">LOGO</div>
    <div class="nav-links">
      <a href="dashboard.php">Home</a>
      <div class="separator"></div>
      <a href="#" class="active">Appointments</a>
      <div class="separator"></div>
      <a href="#">Medication</a>
    </div>
    <a href="bookAppt.php" class="button">
      <i class="icon">📅</i> Book Appointment
    </a>
    <i class="settings">⚙️</i>
  </div>
    
    <!-- Centering Wrapper -->
    <div class="container">
        <h2 class="text-center mt-4">Help FAQ</h2>
    <div style="display: flex; justify-content: center; align-items: center;">
        <div id="chat-container">
            <div id="chatbox">
                <div class="bot-message">
                    <i class="bi bi-robot profile-icon"></i>
                    <div class="botText">
                        <span>Hello! Ask me anything.</span>
                    </div>
                </div>
            </div>
            <input id="userInput" type="text" placeholder="Type your question..." onkeypress="handleKeyPress(event)">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script src="chatbot.js"></script>

</body>
</html>



