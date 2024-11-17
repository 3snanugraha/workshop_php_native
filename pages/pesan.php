<?php
require '../controllers/function.php';
checkAuth();

$user_id = $_SESSION['user_id'];
$contacts = getChatContacts($user_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - WorkSmart</title>
  <meta content="WorkSmart" name="description">
  <meta content="WorkSmart" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo-worksmart.png" rel="icon">
  <link href="assets/img/logo-worksmart.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/brand.css" rel="stylesheet">
  
  <style>
    .chat-contacts {
        height: 550px;
        overflow-y: auto;
    }

    .contact-item {
        padding: 1rem;
        transition: background-color 0.3s;
    }

    .contact-item:hover {
        background-color: rgba(0,0,0,0.05);
    }

    .contact-item.active {
        background-color: rgba(0,0,0,0.1);
    }

    .chat-message {
        margin-bottom: 1rem;
    }

    .message-bubble {
        background-color: #f1f1f1;
        max-width: 70%;
    }

    .own-message .message-bubble {
        background-color: #007bff;
        color: white;
    }
   </style>
</head>

<body>

  <?php require 'header.php'; ?>
  <?php require 'sidebar.php'; ?>

  <main id="main" class="main brand-bg-color">

    <div class="pagetitle">
      <h1 class="text-light">Pesan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Pesan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
            <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-0">
                            <!-- Contacts List -->
                            <div class="col-12 col-lg-4 border-end">
                                <div class="px-4 d-none d-md-block">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control my-3" placeholder="Search...">
                                        </div>
                                    </div>
                                </div>

                                <div class="chat-contacts">
                                    <?php foreach($contacts as $contact): ?>
                                        <a href="#" class="list-group-item list-group-item-action border-0 contact-item" 
                                        data-user-id="<?= $contact['user_id'] ?>">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1 ml-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h5 class="mb-0"><?= $contact['first_name'] . ' ' . $contact['last_name'] ?></h5>
                                                        <small class="text-muted"><?= date('H:i', strtotime($contact['last_message_time'])) ?></small>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <small class="text-truncate"><?= $contact['last_message'] ?></small>
                                                        <?php if($contact['unread_count'] > 0): ?>
                                                            <span class="badge bg-primary rounded-pill"><?= $contact['unread_count'] ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Chat Area -->
                            <div class="col-12 col-lg-8">
                                <div class="chat-area d-flex flex-column" style="height: 600px;">
                                    <div class="chat-header px-4 py-3 border-bottom">
                                        <h5 class="mb-0 brand-color" id="chat-recipient">Select a contact</h5>
                                    </div>
                                    
                                    <div class="chat-messages p-4 flex-grow-1" style="overflow-y: auto;">
                                        <!-- Messages will be loaded here -->
                                    </div>

                                    <div class="chat-input px-4 py-3 border-top">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="message-input" placeholder="Type your message...">
                                            <button class="btn brand-btn" type="button" id="send-message">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>  
  </main>
  </main><!-- End #main -->

  <?php require "modals.php";?>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer brand-bg-color">
    <div class="copyright text-light">
      © Copyright <strong><span>WorkSmart</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  
  <!-- DataTables JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/autohide.js"></script>

  <!-- Chat fungsi -->
<script>
    let currentReceiverId = null;

    document.addEventListener('DOMContentLoaded', function() {
        const contactItems = document.querySelectorAll('.contact-item');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-message');
        const chatMessages = document.querySelector('.chat-messages');
        
        contactItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.dataset.userId;
                const userName = this.querySelector('h5').textContent;
                
                // Update header with selected contact name
                document.getElementById('chat-recipient').textContent = userName;
                
                loadChatHistory(userId);
                currentReceiverId = userId;
                
                // Update active state
                contactItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        sendButton.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        function loadChatHistory(receiverId) {
            fetch(`../controllers/get_chat_history.php?receiver_id=${receiverId}`)
                .then(response => response.json())
                .then(data => {
                    chatMessages.innerHTML = '';
                    data.forEach(message => {
                        const isOwn = message.sender_id == <?= $user_id ?>;
                        const messageHtml = `
                            <div class="chat-message ${isOwn ? 'own-message text-end' : 'other-message'}">
                                <div class="message-bubble d-inline-block p-2 mb-2 rounded">
                                    <div class="message-text">${message.message}</div>
                                    <small class="text-muted">${message.sent_at}</small>
                                </div>
                            </div>
                        `;
                        chatMessages.insertAdjacentHTML('beforeend', messageHtml);
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                });
        }
        
        function sendMessage() {
            if (!currentReceiverId) return;
            
            const message = messageInput.value.trim();
            if (!message) return;
            
            fetch('../controllers/send_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    receiver_id: currentReceiverId,
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageInput.value = '';
                    loadChatHistory(currentReceiverId);
                }
            });
        }
        
        // Auto refresh chat every 5 seconds
        setInterval(() => {
            if (currentReceiverId) {
                loadChatHistory(currentReceiverId);
            }
        }, 5000);
    });
</script>


</body>

</html>