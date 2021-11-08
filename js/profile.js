const image = document.querySelector("#cropBox")

    const fileInput = document.querySelector(".fileInput")
    const uploadPicBtn = document.querySelector(".uploadPicBtn")
    const resetImageBtn = document.querySelector(".fileInputResetBtn")
    const removePicBtn = document.querySelector(".removePicBtn")
    const imageForm = document.querySelector(".imageForm")
    const outerCropWrapper = document.querySelector(".outer-crop-wrapper")
    const userProfilePicture = document.querySelector(".userProfilePicture")

    if (userProfilePicture.src !== userProfilePicture.baseURI && userProfilePicture.src.includes(
            "/svg/profile-pic-default.svg") === false) {
        removePicBtn.classList.remove("hidden")
    }

    const imageCrop = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 2,

        preview: ".preview",

        minCropBoxWidth: 550,
        minCropBoxHeight: 550,

        minContainerHeight: 550,
        minContainerWidth: 550,

        minCanvasWidth: 550,
        minCanvasHeight: 550
    })


    resetImageBtn.addEventListener("click", function() {
        uploadPicBtn.classList.add("hidden")
        imageCrop.destroy()

    })

    fileInput.addEventListener("change", function(e) {
        const imageCrop = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 2,

            preview: ".preview",

            minCropBoxWidth: 550,
            minCropBoxHeight: 550,

            minContainerHeight: 550,
            minContainerWidth: 550,

            minCanvasWidth: 550,
            minCanvasHeight: 550
        })
        const result = getImageURL(this)

        if (e.target.value) {
            uploadPicBtn.classList.remove("hidden")
        }
    })

    const inputImageErrorMessage = document.createElement("small")
    inputImageErrorMessage.innerHTML = "Only images are allowed"
    inputImageErrorMessage.classList.add("d-block")

    uploadPicBtn.addEventListener("click", function() {
        const cropImage = imageCrop.getCroppedCanvas({
            width: 200,
            height: 200,
            fillColor: '#fff',
            imageSmoothingEnabled: false,
            imageSmoothingQuality: 'low',
        })

        if (!cropImage) {

            if (outerCropWrapper.contains(inputImageErrorMessage) === false) {
                outerCropWrapper.appendChild(inputImageErrorMessage)
            }

        } else {
            const finalImage = cropImage.toDataURL();
            const inputWithImageData = document.createElement("input")
            inputWithImageData.type = "text"
            inputWithImageData.name = "newProfilePic"
            inputWithImageData.setAttribute("value", finalImage)
            imageForm.appendChild(inputWithImageData)
            imageForm.submit()
        }
    })

    function getImageURL(input) {
        const reader = new FileReader()
        reader.addEventListener("load", function(e) {
            imageCrop.replace(e.target.result)
        })
        if (input) {
            reader.readAsDataURL(input.files[0])
        }
    }