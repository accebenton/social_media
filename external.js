function editBio() {
    const bioText = document.getElementById('bioText');
    const bioTextarea = document.getElementById('userBio');
    const editBioBtn = document.getElementById('editBioBtn');
    const saveButton = document.getElementById('saveButton');

    // hide bio text and show textarea
    bioText.classList.add('d-none');
    bioTextarea.classList.remove('d-none');
    bioTextarea.value = bioText.textContent;

    // hide edit button and show save button
    editBioBtn.classList.add('d-none');
    saveButton.classList.remove('d-none');
}

function saveBio() {
    const bioText = document.getElementById('bioText');
    const bioTextarea = document.getElementById('userBio');
    const editBioBtn = document.getElementById('editBioBtn'); 
    const saveButton = document.getElementById('saveButton');

    // save new bio
    bioText.textContent = bioTextarea.value;
    bioText.classList.remove('d-none');
    bioTextarea.classList.add('d-none');

    // show edit button and hide save button
    editBioBtn.classList.remove('d-none');
    saveButton.classList.add('d-none');
}

//like counter

let likeCount = 0; //initialize variable

function likeCounts() {
    likeCount++ //increments like count variable initialized above
    document.getElementById('likeCounter').textContent = likeCount; //gets HTML by id 
}

document.getElementById('likeLink').addEventListener('click', likeCounts);


