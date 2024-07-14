$(document).ready(function() {
    var isLoading = false;
    var pageNumber = 1;
    var pageSize = 10;

    // Function to load more messages when scrolling to the bottom
    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            loadMoreMessages();
        }
    });

    // Function to load messages from the server
    function loadMoreMessages() {
        if (!isLoading) {
            isLoading = true;
            $("#loading").show(); // Show loading spinner or message

            // AJAX request to fetch messages from the server
            $.ajax({
                url: 'fetch_messages.php',
                type: 'GET',
                data: {
                    page: pageNumber,
                    size: pageSize
                },
                dataType: 'json',
                success: function(response) {
                    // Process the received messages
                    if (response.success) {
                        response.messages.forEach(function(message) {
                            var messageHTML = "<div class='message'>" +
                                              "<span class='sender'>" + message.sender + "</span>: " +
                                              "<span class='content'>" + message.content + "</span>" +
                                              "<span class='timestamp'>" + message.timestamp + "</span>" +
                                              "</div>";
                            $("#message-list").append(messageHTML);
                        });
                        pageNumber++;
                    } else {
                        console.error('Error fetching messages:', response.error);
                    }
                    isLoading = false;
                    $("#loading").hide(); // Hide loading spinner or message
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    isLoading = false;
                    $("#loading").hide(); // Hide loading spinner or message
                }
            });
        }
    }

    // Initial load of messages
    loadMoreMessages();
});