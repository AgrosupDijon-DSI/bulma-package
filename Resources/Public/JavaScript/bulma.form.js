document.addEventListener('DOMContentLoaded', () => {

    // Get all "file-input" elements
    const $filesInput = Array.prototype.slice.call(document.querySelectorAll('.file-input'), 0);

    if ($filesInput.length > 0) {

        // Add a click event on each of them
        $filesInput.forEach(el => {
            el.addEventListener('change', () => {

                // If there is a file
                if (el.files.length > 0) {
                    var fileName;
                    if (el.previousElementSibling.className == 'file-name') {
                        // Retrieve previous sibling ".file-name" element
                        fileName = el.previousElementSibling;
                    } else {
                        // Or create the ".file-name" element
                        fileName = document.createElement('span');
                        fileName.className = 'file-name';
                        el.parentNode.insertBefore(fileName, el);
                    }
                    // Insert the file name in ".file-name"
                    fileName.innerHTML = el.files[0].name;
                }

            });
        });
    }

});
