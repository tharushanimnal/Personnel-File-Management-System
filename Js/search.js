function searchProduct() {
    let searchInput = document.getElementById("searchInput").value;
    
    if (searchInput.length > 0) {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "php/basicS.php?name=" + searchInput, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById("data-table").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    } else {
        document.getElementById("data-table").innerHTML = "";
    }
}

function advSearchProduct() {
    let incrementDate = document.getElementById("d1").value;
    let reportDate = document.getElementById("d2").value;
    let rank = document.getElementById("rank").value;
    let tradate = document.getElementById("d3").value;

    let xhr = new XMLHttpRequest();
    let params = "increment_date=" + encodeURIComponent(incrementDate) +
                 "&report_date=" + encodeURIComponent(reportDate) +
                 "&rank=" + encodeURIComponent(rank) +
                 "&tra_date=" + encodeURIComponent(tradate);

    xhr.open("GET", "php/filter.php?" + params, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById("data-table").innerHTML = xhr.responseText;
            closeFilter();
            clearFilterFields();
        }
    };
    xhr.send();
}

function clearFilterFields() {
    document.getElementById("d1").value = "";
    document.getElementById("d2").value = "";
    document.getElementById("rank").value = "";
    document.getElementById("d3").value = "";
}