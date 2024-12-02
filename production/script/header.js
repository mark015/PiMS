$(document).ready(function () {
    // Function to fetch notifications
    function fetchNotifications() {
      $.ajax({
        url: 'data/fetchNotifications.php',  // Endpoint to fetch notifications
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            var messages = response.notifications;
            var messageList = $('#messageDropdown');
            var messageBadge = $('#messageBadge');
            messageList.empty();  // Clear previous notifications

              // Update badge and visibility
              if (messages.length > 0) {
                  messageBadge.text(messages.length).show();  // Show badge with count
              } else {
                  messageBadge.hide();  // Hide badge if no notifications
              }
            // If there are notifications
            if (messages.length > 0) {
              messages.forEach(function(notification) {
                var notificationItem = `<li class="nav-item">
                                        <a class="dropdown-item">
                                            <span><strong>${notification.title}</strong></span>
                                            <span class="time">${notification.time}</span>
                                        </a>
                                      </li>`;
              
                messageList.append(notificationItem);
                
              });
              messageList.append(`
                <li class="nav-item">
                    <div class="text-center">
                        <a href="index?link=documents" class="dropdown-item">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </li>`);
            } else {
              messageList.append('<li class="nav-item"><a class="dropdown-item">No new notifications</a></li>');
            }
            
          }
        },
        error: function() {
          alert("An error occurred while fetching notifications.");
        }
        
      });
    }
  
    // Call function to load notifications on page load
    fetchNotifications();
  
    // Optional: Refresh notifications every 30 seconds (or as per your preference)
    // setInterval(fetchNotifications, 3000);
  });
  