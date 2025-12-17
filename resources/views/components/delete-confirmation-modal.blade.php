@props(['title' => 'Konfirmasi', 'message' => 'Apakah Anda yakin?', 'action' => 'delete'])

<div id="confirmationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-sm mx-auto p-6 space-y-4">
        <div class="flex items-center gap-3">
            <div id="iconContainer" class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-100">
                <i id="modalIcon" class='bx bx-trash text-rose-600 text-xl'></i>
            </div>
        </div>
        
        <div class="space-y-2">
            <h3 id="modalTitle" class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
            <p id="modalMessage" class="text-sm text-slate-600">{{ $message }}</p>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="button" id="cancelBtn" class="btn-secondary flex-1">Batal</button>
            <button type="button" id="confirmBtn" class="inline-flex items-center justify-center gap-2 flex-1 rounded-lg px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700">
                <i id="confirmBtnIcon" class='bx bx-trash'></i><span id="confirmBtnText">Hapus</span>
            </button>
        </div>
    </div>
</div>

<script>
    let pendingForm = null;

    function showConfirmation(form, title = 'Konfirmasi', message = 'Apakah Anda yakin?', action = 'delete') {
        pendingForm = form;
        document.getElementById('confirmationModal').classList.remove('hidden');
        
        // Update title dan message
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalMessage').textContent = message;
        
        // Update icon dan button text berdasarkan action type
        const iconContainer = document.getElementById('iconContainer');
        const modalIcon = document.getElementById('modalIcon');
        const confirmBtn = document.getElementById('confirmBtn');
        const confirmBtnIcon = document.getElementById('confirmBtnIcon');
        const confirmBtnText = document.getElementById('confirmBtnText');
        
        if (action === 'reset') {
            iconContainer.className = 'flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-amber-100';
            modalIcon.className = 'bx bx-reset text-amber-600 text-xl';
            confirmBtn.className = 'inline-flex items-center justify-center gap-2 flex-1 rounded-lg px-4 py-2 text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700';
            confirmBtnIcon.className = 'bx bx-reset';
            confirmBtnText.textContent = 'Reset';
        } else if (action === 'delete') {
            iconContainer.className = 'flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-100';
            modalIcon.className = 'bx bx-trash text-rose-600 text-xl';
            confirmBtn.className = 'inline-flex items-center justify-center gap-2 flex-1 rounded-lg px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700';
            confirmBtnIcon.className = 'bx bx-trash';
            confirmBtnText.textContent = 'Hapus';
        }
    }

    document.getElementById('cancelBtn').addEventListener('click', function() {
        document.getElementById('confirmationModal').classList.add('hidden');
        pendingForm = null;
    });

    document.getElementById('confirmBtn').addEventListener('click', function() {
        if (pendingForm) {
            pendingForm.submit();
        }
    });

    // Close modal saat ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('confirmationModal').classList.add('hidden');
            pendingForm = null;
        }
    });
</script>
