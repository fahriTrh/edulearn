<div>
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 flex gap-4">
        <button wire:click="openMaterialModal" class="p-3 bg-indigo-600 text-white rounded-lg font-semibold">
            ➕ Tambah Materi
        </button>
        <button wire:click="openAssignmentModal" class="p-3 bg-green-600 text-white rounded-lg font-semibold">
            ➕ Tambah Tugas
        </button>
        <button wire:click="openStudentModal" class="p-3 bg-purple-600 text-white rounded-lg font-semibold">
            ➕ Tambah Mahasiswa
        </button>
    </div>

    {{-- Materials Section --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Materi</h2>
        <div class="space-y-4">
            @forelse($materials as $material)
            <div class="border rounded-lg p-4 flex justify-between items-center">
                <div>
                    <h3 class="font-bold">{{ $material['title'] }}</h3>
                    <p class="text-sm text-gray-600">{{ $material['type'] }}</p>
                </div>
                <div class="flex gap-2">
                    <button wire:click="editMaterial({{ $material['id'] }})" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Edit</button>
                    <button wire:click="deleteMaterial({{ $material['id'] }})" wire:confirm="Hapus materi ini?" class="px-3 py-1 bg-red-600 text-white rounded text-sm">Hapus</button>
                </div>
            </div>
            @empty
            <p class="text-gray-500">Belum ada materi</p>
            @endforelse
        </div>
    </div>

    {{-- Assignments Section --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Tugas</h2>
        <div class="space-y-4">
            @forelse($formatted_assignments as $assignment)
            <div class="border rounded-lg p-4">
                <h3 class="font-bold">{{ $assignment['title'] }}</h3>
                <p class="text-sm text-gray-600">Deadline: {{ $assignment['deadline'] }}</p>
                <p class="text-sm text-gray-600">Submissions: {{ $assignment['submissions'] }}/{{ $assignment['total'] }}</p>
            </div>
            @empty
            <p class="text-gray-500">Belum ada tugas</p>
            @endforelse
        </div>
    </div>

    {{-- Students Section --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-bold mb-4">Mahasiswa</h2>
        <div class="space-y-2">
            @forelse($mahasiswa as $student)
            <div class="border rounded-lg p-4 flex justify-between items-center">
                <div>
                    <h3 class="font-bold">{{ $student->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $student->nim }} - {{ $student->email }}</p>
                </div>
                <button wire:click="hapusMahasiswaKelas({{ $student->id }})" wire:confirm="Hapus mahasiswa dari kelas?" class="px-3 py-1 bg-red-600 text-white rounded text-sm">Hapus</button>
            </div>
            @empty
            <p class="text-gray-500">Belum ada mahasiswa</p>
            @endforelse
        </div>
    </div>

    {{-- Material Modal --}}
    @if($showMaterialModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-[1000] flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-semibold mb-6">{{ $editingMaterialId ? 'Edit Materi' : 'Tambah Materi' }}</h2>
            <form wire:submit="saveMaterial">
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Judul</label>
                    <input type="text" wire:model="material_title" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('material_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Tipe</label>
                    <select wire:model="material_type" class="w-full p-3 border-2 border-gray-200 rounded-lg">
                        <option value="pdf">PDF</option>
                        <option value="document">Document</option>
                        <option value="link">Link</option>
                        <option value="video">Video</option>
                    </select>
                </div>
                @if(in_array($material_type, ['pdf', 'document']))
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">File</label>
                    <input type="file" wire:model="material_file" class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('material_file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @endif
                @if($material_type === 'link')
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">URL</label>
                    <input type="url" wire:model="material_link" class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('material_link') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @endif
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Deskripsi</label>
                    <textarea wire:model="material_description" class="w-full p-3 border-2 border-gray-200 rounded-lg"></textarea>
                </div>
                <div class="flex gap-4">
                    <button type="button" wire:click="closeMaterialModal" class="flex-1 p-3 bg-gray-200 text-gray-700 rounded-lg">Batal</button>
                    <button type="submit" class="flex-1 p-3 bg-indigo-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Assignment Modal --}}
    @if($showAssignmentModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-[1000] flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-semibold mb-6">Tambah Tugas</h2>
            <form wire:submit="saveAssignment">
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Judul</label>
                    <input type="text" wire:model="assignment_title" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Deskripsi</label>
                    <textarea wire:model="assignment_description" required class="w-full p-3 border-2 border-gray-200 rounded-lg"></textarea>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Deadline</label>
                    <input type="datetime-local" wire:model="assignment_deadline" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Bobot (%)</label>
                    <input type="number" wire:model="assignment_weight" min="0" max="100" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                </div>
                <div class="flex gap-4">
                    <button type="button" wire:click="closeAssignmentModal" class="flex-1 p-3 bg-gray-200 text-gray-700 rounded-lg">Batal</button>
                    <button type="submit" class="flex-1 p-3 bg-green-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Student Modal --}}
    @if($showStudentModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-[1000] flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl max-w-md w-full">
            <h2 class="text-2xl font-semibold mb-6">Tambah Mahasiswa</h2>
            <form wire:submit="tambahMahasiswaKelas">
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">NIM atau Email</label>
                    <input type="text" wire:model="student_identifier" required class="w-full p-3 border-2 border-gray-200 rounded-lg" placeholder="Masukkan NIM atau Email">
                </div>
                <div class="flex gap-4">
                    <button type="button" wire:click="closeStudentModal" class="flex-1 p-3 bg-gray-200 text-gray-700 rounded-lg">Batal</button>
                    <button type="submit" class="flex-1 p-3 bg-purple-600 text-white rounded-lg">Tambah</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

