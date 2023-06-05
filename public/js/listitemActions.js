function switchFilterButtonClasses(button) {
    if (button.classList.contains('alert-danger')) {
        button.classList.remove('alert-danger')
        button.classList.add('alert-warning')
    } else {
        button.classList.add('alert-danger')
        button.classList.remove('alert-warning')
    }
}

function removeImageItem(id, removeButton) {
    axios.post('/api/item/' + id + '/remove-image')
        .then(response => {
            document.getElementById('imageItem' + id).src = '';
            removeButton.remove()
        })
}
function saveSharedList(id) {
    let sharingList = document.getElementsByName('sharingList[]')

    let sharingAssocArray = {}

    sharingList.forEach((element) => {
        sharingAssocArray[element.dataset.userId.toString()] = element.options[element.selectedIndex].value
    })

    console.log(sharingList);
    console.log(sharingAssocArray);

    axios.post('/api/todolist/' + id + '/share', {
        'sharingList': sharingAssocArray
    })
        .then((response) => {
            console.log(response);
        })
}

function deleteItem(id) {
    axios.post('/api/item/delete', {'id': id})
        .then((response) => {
            document.getElementById('item'+id).remove()
        })
        .catch((error) => {
            console.log(error);
        })
}
function editItem(id) {
    let title = document.getElementById('titleInputItem'+id).value
    let description = document.getElementById('descriptionInputItem'+id).value
    let titleNode = document.getElementById('titleItem'+id)
    let descriptionNode = document.getElementById('descriptionItem'+id)
    let tags = document.getElementById('tagsItem'+id)

    let tagsToSave = [];
    let tagsTitles = ' ';
    let tagsOptions = tags && tags.options;
    let option;

    for (let i = 0; i < tagsOptions.length; i++) {
        option = tagsOptions[i];

        if (option.selected) {
            tagsToSave.push(option.value || option.text);
            tagsTitles += '<span class="alert alert-warning px-2 py-0 me-1">' + option.text + '</span>'
        }
    }

    let imageInput = document.getElementById('imageInput' + id)
    let imageFile = imageInput.files[0];
    if (imageFile) {
        let formData = new FormData();
        let imageReader = new FileReader();
        let imageNode = document.getElementById('imageItem' + id);
        formData.append("image", imageFile);
        axios.post('/api/item/' + id + '/image/update', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then((response) => {
            imageReader.onloadend = function () {
                imageNode.src = imageReader.result
            }
            imageReader.readAsDataURL(imageFile)
            let oldRemoveButton = document.getElementById('removeImageButton' + id)
            if (!oldRemoveButton) {
                let newButton = '<button type="button" class="btn btn-danger btn-sm" onclick="removeImageItem( ' + id + ', this )" id="removeImageButton' + id + '">Убрать изображение</button>'
                imageInput.insertAdjacentHTML('afterend', newButton)
            }
            imageInput.value = ''
        })
    }

    axios.post('/api/item/update', {
            'id': id,
            'title': title,
            'description': description,
            'tags': tagsToSave,
        })
        .then((response) => {
            titleNode.innerText = title
            titleNode.innerHTML += tagsTitles
            descriptionNode.innerText = description
        })
        .catch((error) => {
            console.log(error);
        })
}
function checkItem(id) {
    let checkButton = document.getElementById('checkButton'+id)
    let isChecked = checkButton.classList.contains('btn-dark')

    switchCheckButtonClasses(id, isChecked)

    if (isChecked) {
        axios.post('/api/uncheck', {'id': id})
            .catch((error) => {
                console.log(error);
                switchCheckButtonClasses(id, isChecked)
            })
    } else {
        axios.post('/api/check', {'id': id})
            .catch((error) => {
                console.log(error);
                switchCheckButtonClasses(id, isChecked)
            })
    }
}

function switchCheckButtonClasses(id, isChecked) {
    let checkButton = document.getElementById('checkButton'+id)

    if (isChecked) {
        checkButton.classList.remove('btn-dark')
        checkButton.classList.add('text-white')
        checkButton.classList.add('btn-outline-dark')
    } else {
        checkButton.classList.add('btn-dark')
        checkButton.classList.remove('text-white')
        checkButton.classList.remove('btn-outline-dark')
    }

}
