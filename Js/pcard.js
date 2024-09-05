document.addEventListener('DOMContentLoaded', function() {
    fetchProfiles();
    document.getElementById('search-keyword').addEventListener('input', filterProfiles);
});

let profiles = []; 

function fetchProfiles() {
    fetch('php/pcard.php')
        .then(response => response.json())
        .then(data => {
            profiles = data;
            displayProfiles(profiles); 
        })
        .catch(error => console.error('Error fetching profiles:', error));
}

function displayProfiles(profilesToDisplay) {
    let profileContainer = document.querySelector('.profile-container');
    profileContainer.innerHTML = ''; 

    profilesToDisplay.forEach(profile => {
        let profileCard = document.createElement('div');
        profileCard.className = 'profile-card';
        profileCard.setAttribute('data-name', profile.name1);
        profileCard.setAttribute('data-position', profile.position);
        profileCard.setAttribute('data-employee-id', profile.employee_id);
        profileCard.onclick = function(event) {
            showLargeCard(this, event);
        };

        let img = document.createElement('img');
        img.src = '/Personnel-File-Management-System/' + profile.photo; //change the path
        img.alt = 'Profile ' + profile.employee_id;

        profileCard.appendChild(img);
        profileContainer.appendChild(profileCard);
    });
}

function filterProfiles() {
    let searchValue = document.getElementById('search-keyword').value.toLowerCase();
    if (searchValue === '') {
        displayProfiles(profiles); 
    } else {
        let filteredProfiles = profiles.filter(profile =>
            profile.employee_id.toLowerCase().includes(searchValue)
        );
        displayProfiles(filteredProfiles); 
    }
}

function showLargeCard(element, event) {
    var largeCard = document.getElementById('large-card');
    var imgSrc = element.querySelector('img').src;
    largeCard.querySelector('img').src = imgSrc;

    var name = element.getAttribute('data-name');
    var position = element.getAttribute('data-position');

    document.querySelector('.na1').textContent = name;
    document.querySelector('.po1').textContent = position;

    var rect = element.getBoundingClientRect();
    largeCard.style.top = (rect.top + window.scrollY) + 'px';
    largeCard.style.left = (rect.left + window.scrollX) + 'px';

    largeCard.style.display = 'block';

    event.stopPropagation();
}

document.addEventListener('click', function(event) {
    var largeCard = document.getElementById('large-card');
    if (!largeCard.contains(event.target) && largeCard.style.display === 'block') {
        largeCard.style.display = 'none';
    }
});

document.getElementById('large-card').addEventListener('click', function(event) {
    event.stopPropagation();
});

function loadEditPage() {
    var largeCardImgSrc = document.getElementById('large-profile-img').src;
    localStorage.setItem('editImageSrc', largeCardImgSrc);
    window.location.href = 'profile.html';
}

document.querySelector('.edit-button').addEventListener('click', loadEditPage);

if (localStorage.getItem('loggedIn') !== 'true') {
    window.location.href = 'login.html';
}
