<script>
$(document).ready(function() {
    // Function to fetch and update counts
    function fetchEmployeeCounts() {
        $.ajax({
            url: 'data/getDashboardData.php', // Your PHP file to get the data
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update the count values in the respective tiles
                    $('#encodedItemsCount').text(response.data.encoded_item_count);
                    $('#withdrawalItemsCount').text(response.data.withdral_item_count);
                    $('#schoolCount').text(response.data.school_count);
                } else {
                    console.error('Failed to fetch employee counts:', response.message);
                }
            },
            error: function() {
                console.error('An error occurred while fetching employee counts.');
            }
        });
    }

    // Call the function to fetch employee counts on page load
    fetchEmployeeCounts();
    
    // Optionally, you can set an interval to update the counts every 24 hours (86400000 ms)
    setInterval(fetchEmployeeCounts, 3000); // 24 hours
});
</script>