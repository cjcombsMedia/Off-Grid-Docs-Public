// Function to toggle between light and dark mode
function toggleMode() {
    const body = document.body;
    body.classList.toggle('dark-mode');
    const isDarkMode = body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');
    document.getElementById('theme-toggle').innerHTML = isDarkMode ? '<img src="assets/darkmode-icon.svg" alt="Toggle Theme">' : '<img src="assets/lightmode-icon.svg" alt="Toggle Theme">';
}

// Function to fetch and display categories
function fetchCategories() {
    fetch('php/list-categories.php')
        .then(response => response.json())
        .then(categories => {
            const accordion = document.getElementById('accordion');
            const mobileCategories = document.querySelector('.mobile-categories');
            accordion.innerHTML = '';
            mobileCategories.innerHTML = '';
            categories.forEach(category => {
                // Desktop accordion
                const button = document.createElement('button');
                button.className = 'accordion';
                button.innerHTML = `<img src="${category.icon}" alt="${category.name}" class="category-icon"> ${category.name}`;
                button.setAttribute('data-category', category.name);

                const panel = document.createElement('div');
                panel.className = 'panel';

                category.files.forEach(file => {
                    const link = document.createElement('a');
                    link.href = `uploads/${category.name}/${file.name}`;
                    link.target = 'content-frame'; // Target the iframe
                    link.innerHTML = `<img src="${file.icon}" alt="${file.name}" class="file-icon"> ${file.name}`;
                    panel.appendChild(link);
                    panel.appendChild(document.createElement('br'));
                });

                accordion.appendChild(button);
                accordion.appendChild(panel);

                button.addEventListener('click', function () {
                    this.classList.toggle('active');
                    const panel = this.nextElementSibling;
                    panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
                });

                button.addEventListener('contextmenu', function (event) {
                    event.preventDefault();
                    showContextMenu(event, category.name);
                });

                // Mobile categories
                const mobileCategory = document.createElement('div');
                mobileCategory.className = 'mobile-category';
                mobileCategory.innerHTML = `<a href='category.php?category=${category.name}'>${category.name}</a>`;
                mobileCategory.setAttribute('data-category', category.name);

                mobileCategory.addEventListener('contextmenu', function (event) {
                    event.preventDefault();
                    showContextMenu(event, category.name);
                });

                mobileCategory.addEventListener('touchstart', function (event) {
                    startTouch(event, category.name);
                });

                mobileCategories.appendChild(mobileCategory);
            });
        })
        .catch(error => console.error('Error fetching categories:', error));
}

// Function to fetch and display metadata
function fetchMetadata() {
    fetch('php/get-metadata.php')
        .then(response => response.json())
        .then(metadata => {
            if (metadata.sectionstitle) {
                document.getElementById('sections-title').textContent = metadata.sectionstitle;
            }
            if (metadata.sitetitle) {
                document.getElementById('site-title').textContent = metadata.sitetitle;
            }
        })
        .catch(error => console.error('Error fetching metadata:', error));
}

// Function to update metadata
function updateMetadata(key, value) {
    fetch('php/update-metadata.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ key, value })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Metadata updated successfully.');
        } else {
            console.error('Failed to update metadata.');
        }
    })
    .catch(error => console.error('Error updating metadata:', error));
}

// Apply dark mode if previously set and fetch categories and metadata
document.addEventListener('DOMContentLoaded', () => {
    const darkMode = localStorage.getItem('darkMode');
    if (darkMode === 'enabled') {
        document.body.classList.add('dark-mode');
        document.getElementById('theme-toggle').innerHTML = '<img src="assets/darkmode-icon.svg" alt="Toggle Theme">';
    }
    fetchCategories();
    fetchMetadata(); // Fetch metadata on page load
    fetchTotalItems(); // Fetch total items on page load
});

// Event listener for the theme toggle button
document.getElementById('theme-toggle').addEventListener('click', toggleMode);

// Function to toggle the sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show');
}

// Event listener for the hamburger menu
document.getElementById('hamburger').addEventListener('click', toggleSidebar);

// Function to handle the logo edit
document.getElementById('edit-logo').addEventListener('click', () => {
    const logoContainer = document.querySelector('.logo-container');
    const logo = logoContainer.querySelector('.logo');
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.style.display = 'none';
    input.onchange = () => {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                logo.src = e.target.result;
                // Here you would send the file to the server to update the logo image
                // Use FormData to send the file via AJAX to a PHP script that handles the upload
            };
            reader.readAsDataURL(file);
        }
    };
    input.click();
});

// Function to handle inline title editing
function handleTitleEdit(titleId, editIconId) {
    const titleSpan = document.getElementById(titleId);
    const editIcon = document.getElementById(editIconId);
    const originalText = titleSpan.textContent;

    titleSpan.contentEditable = true;
    titleSpan.classList.add('editable');
    titleSpan.focus();

    const saveIcon = document.createElement('span');
    saveIcon.innerHTML = '💾';
    saveIcon.className = 'edit-icon';
    saveIcon.title = 'Save Title';
    saveIcon.style.cursor = 'pointer';
    saveIcon.style.marginLeft = '10px';

    const cancelIcon = document.createElement('span');
    cancelIcon.innerHTML = '❌';
    cancelIcon.className = 'edit-icon';
    cancelIcon.title = 'Cancel Edit';
    cancelIcon.style.cursor = 'pointer';
    cancelIcon.style.marginLeft = '10px';

    editIcon.style.display = 'none';
    titleSpan.insertAdjacentElement('afterend', saveIcon);
    titleSpan.insertAdjacentElement('afterend', cancelIcon);

    saveIcon.addEventListener('click', () => {
        titleSpan.contentEditable = false;
        titleSpan.classList.remove('editable');
        saveIcon.remove();
        cancelIcon.remove();
        editIcon.style.display = 'inline';
        updateMetadata(titleId.replace('-', ''), titleSpan.textContent);
    });

    cancelIcon.addEventListener('click', () => {
        titleSpan.contentEditable = false;
        titleSpan.classList.remove('editable');
        titleSpan.textContent = originalText;
        saveIcon.remove();
        cancelIcon.remove();
        editIcon.style.display = 'inline';
    });
}

// Add event listeners for title edit icons
document.getElementById('edit-site-title').addEventListener('click', () => handleTitleEdit('site-title', 'edit-site-title'));
document.getElementById('edit-sections-title').addEventListener('click', () => handleTitleEdit('sections-title', 'edit-sections-title'));

// Context menu functions
function showContextMenu(event, category) {
    const contextMenu = document.getElementById('context-menu');
    contextMenu.style.left = `${event.pageX}px`;
    contextMenu.style.top = `${event.pageY}px`;
    contextMenu.classList.remove('hidden');
    contextMenu.setAttribute('data-category', category);
}

function hideContextMenu() {
    const contextMenu = document.getElementById('context-menu');
    contextMenu.classList.add('hidden');
}

function editCategory() {
    const contextMenu = document.getElementById('context-menu');
    const category = contextMenu.getAttribute('data-category');
    const newCategoryName = prompt('Enter new category name:', category);
    if (newCategoryName && newCategoryName !== category) {
        // Send AJAX request to edit the category
        fetch(`php/edit-category.php?oldCategory=${category}&newCategory=${newCategoryName}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchCategories();
                } else {
                    alert('Failed to edit category.');
                }
            });
    }
    hideContextMenu();
}

function deleteCategory() {
    const contextMenu = document.getElementById('context-menu');
    const category = contextMenu.getAttribute('data-category');
    const confirmDelete = confirm(`Are you sure you want to delete the category "${category}"?`);
    if (confirmDelete) {
        // Send AJAX request to delete the category
        fetch(`php/delete-category.php?category=${category}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchCategories();
                } else {
                    console.error('Failed to delete category:', data.message);
                    alert('Failed to delete category: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error deleting category:', error);
                alert('Error deleting category: ' + error);
            });
    }
    hideContextMenu();
}

// Add category functions using prompt
function addCategory() {
    const newCategoryName = prompt('Enter new category name:');
    if (newCategoryName) {
        // Send AJAX request to add the new category
        fetch(`php/add-category.php?category=${newCategoryName}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchCategories();
                } else {
                    alert('Failed to add category.');
                }
            });
    } else {
        alert('Category name cannot be empty.');
    }
}

// Event listener for the Add Category button
document.querySelector('.add-category-btn').addEventListener('click', addCategory);

// Hide context menu on click outside
document.addEventListener('click', (event) => {
    if (!event.target.classList.contains('context-menu-item')) {
        hideContextMenu();
    }
});

// Handle touch events for context menu on mobile
let touchTimeout;
function startTouch(event, category) {
    touchTimeout = setTimeout(() => {
        showContextMenu(event, category);
    }, 800); // 800ms for tap and hold
    event.target.addEventListener('touchend', cancelTouch);
}

function cancelTouch() {
    clearTimeout(touchTimeout);
    this.removeEventListener('touchend', cancelTouch);
}

// Function to fetch and display the total number of items
function fetchTotalItems() {
    fetch('php/count-items.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-items-count').textContent = data.totalItems;
        })
        .catch(error => console.error('Error fetching total items:', error));
}

// Apply dark mode if previously set and fetch categories and metadata
document.addEventListener('DOMContentLoaded', () => {
    const darkMode = localStorage.getItem('darkMode');
    if (darkMode === 'enabled') {
        document.body.classList.add('dark-mode');
        document.getElementById('theme-toggle').innerHTML = '<img src="assets/darkmode-icon.svg" alt="Toggle Theme">';
    }
    fetchCategories();
    fetchMetadata(); // Fetch metadata on page load
    fetchTotalItems(); // Fetch total items on page load
});

// Handle file upload with AJAX
document.getElementById('upload-form').addEventListener('submit', function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`File uploaded to ${formData.get('category')} successfully!`);
            fetchCategories();
        } else {
            alert(`File upload failed: ${data.message}`);
        }
    })
    .catch(error => {
        alert('File upload failed: ' + error);
    });
});
