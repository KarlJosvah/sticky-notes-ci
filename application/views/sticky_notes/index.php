<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Sticky Notes</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>

<div class="container">
    <header class="header">
        <h1>Sticky Notes</h1>
    </header>

    <div class="notes-grid">
        <?php 
        $i = 0;
        foreach ($notes as $note): 
            $color_class = 'color-' . ($i % 4);
        ?>
            <div class="note-card <?php echo $color_class; ?>" id="note-<?php echo $note['id']; ?>">
                <h2><?php echo htmlspecialchars($note['title']); ?></h2>
                <p><?php echo htmlspecialchars($note['content']); ?></p>
                <div class="note-actions">
                    <button class="btn-icon" onclick="openEditModal(<?php echo $note['id']; ?>)" title="Edit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>
                    <button class="btn-icon" title="Delete" onclick="openDeleteModal(<?php echo $note['id']; ?>)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </button>
                </div>
            </div>
        <?php 
            $i++;
        endforeach; 
        ?>

        <div class="note-card add-card" onclick="openAddModal()">
            <div class="plus-icon">+</div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="noteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">New Note</h2>
        </div>
        <?php echo form_open('sticky_notes/create', array('id' => 'noteForm')); ?>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter title..." required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" placeholder="Write your note here..." required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary" id="submitBtn">Save Note</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Delete Note</h2>
        </div>
        <div class="form-group">
            <p>Are you sure you want to delete this note? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Delete</a>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('noteModal');
    const modalTitle = document.getElementById('modalTitle');
    const noteForm = document.getElementById('noteForm');
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const submitBtn = document.getElementById('submitBtn');

    function openAddModal() {
        modalTitle.innerText = 'New Note';
        noteForm.action = "<?php echo site_url('sticky_notes/create'); ?>";
        titleInput.value = '';
        contentInput.value = '';
        submitBtn.innerText = 'Save Note';
        modal.style.display = 'block';
    }

    function openEditModal(id) {
        modalTitle.innerText = 'Edit Note';
        noteForm.action = "<?php echo site_url('sticky_notes/edit/'); ?>" + id;
        submitBtn.innerText = 'Update Note';
        
        // Fetch note data via AJAX
        fetch("<?php echo site_url('sticky_notes/get_note_json/'); ?>" + id)
            .then(response => response.json())
            .then(data => {
                titleInput.value = data.title;
                contentInput.value = data.content;
                modal.style.display = 'block';
            });
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    // Delete Modal Logic
    const deleteModal = document.getElementById('deleteModal');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    function openDeleteModal(id) {
        confirmDeleteBtn.href = "<?php echo site_url('sticky_notes/delete/'); ?>" + id;
        deleteModal.style.display = 'block';
    }

    function closeDeleteModal() {
        deleteModal.style.display = 'none';
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
        if (event.target == deleteModal) {
            closeDeleteModal();
        }
    }
</script>

</body>
</html>
