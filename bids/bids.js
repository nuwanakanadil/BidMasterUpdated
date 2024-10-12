function searchById() {
    var id = document.getElementById('searchId').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'search_bids.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('eventsTableBody').innerHTML = this.responseText;
    };
    xhr.send('id=' + id);
}

function deleteById() {
    var id = document.getElementById('deleteId').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_bids.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('result').innerHTML = this.responseText;
        location.reload(); // Reload the page to reflect changes
    };
    xhr.send('id=' + id);
}

function resetTable() {
    location.reload();   
}


function searchItemsById() {
    var id = document.getElementById('searchId2').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'search_items.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('eventsTableBody2').innerHTML = this.responseText;
    };
    xhr.send('id=' + id);
}


function acceptItem(button) {
    const itemId = button.getAttribute('data-id');

    if (confirm("Are you sure you want to accept this item?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "accept_item.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText); // Show a message from the server
                refreshItems(); // Call the function to refresh the items in the UI
            }
        };
        xhr.send("id=" + itemId);
    }
}

function refreshItems() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_seller_items.php", true); // Create a new PHP file to fetch items
    xhr.onload = function() {
        document.getElementById('eventsTableBody2').innerHTML = this.responseText;
    };
    xhr.send();
}

function declineItem(button) {
    const itemId = button.getAttribute('data-id');

    if (confirm("Are you sure you want to decline this item?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "decline_item.php", true); 
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const row = document.getElementById("row-" + itemId);
                if (row) {
                    row.remove(); // Remove the row from the UI
                } else {
                    console.error("Row with ID 'row-" + itemId + "' not found");
                }
                alert(xhr.responseText);
            }
        };
        xhr.send("id=" + itemId); 
    }
}


