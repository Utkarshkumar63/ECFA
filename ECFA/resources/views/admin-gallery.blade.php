@extends('layouts.app')

@section('content')
<!-- Premium Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    /* Scoped Styles */
    #gallery-manager-scope {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1e293b;
        background-color: #f8fafc;
    }

    .gallery-page-header {
        background: white !important;
        border-bottom: 1px solid #e2e8f0;
    }

    .control-card {
        background: white;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04);
    }

    /* Reference Image Buttons */
    .filter-container {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }

    .filter-pill {
        padding: 10px 28px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .filter-pill.active {
        background-color: #0f172a;
        color: white;
        box-shadow: 0 10px 20px -5px rgba(15, 23, 42, 0.3);
    }

    .filter-pill.all-photos:not(.active) {
        border-color: #e2e8f0;
        color: #64748b;
    }

    .filter-pill.tournaments {
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .filter-pill.tournaments.active {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }

    .filter-pill.training {
        border-color: #e2e8f0;
        color: #64748b;
    }

    .filter-pill.training.active {
        background-color: #64748b;
        color: white;
    }

    /* Base Card Style */
    .asset-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: white;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
    }

    .asset-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08);
        border-color: #fbbf24;
    }

    /* View Modes */
    .view-list #galleryContainer {
        display: flex !important;
        flex-direction: column !important;
        gap: 1rem !important;
    }

    .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Adjustments for List View to ensure description shows well */
.view-list .card-info {
    max-width: 400px;
}

    .view-list .asset-card {
        flex-direction: row !important;
        height: 120px !important;
        border-radius: 1.25rem !important;
    }

    .view-list .img-wrapper {
        width: 180px !important;
        height: 100% !important;
        aspect-ratio: auto !important;
        border-radius: 1.25rem 0 0 1.25rem !important;
    }

    .view-list .card-content-area {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 2rem !important;
    }

    .active-view {
        background-color: #0f172a !important;
        color: white !important;
    }

    .upload-zone {
        transition: all 0.3s ease;
        border: 2px dashed #e2e8f0;
    }

    .btn-primary-dark {
        background: #0f172a;
        transition: all 0.3s ease;
    }

    /* Hidden elements for filtering */
    .hidden-item {
        display: none !important;
    }
</style>

<div id="gallery-manager-scope" class="min-h-screen">
    <!-- Sub-Header -->
    <div class="gallery-page-header sticky top-0 z-40">
        <div class="max-w-[1440px] mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                    <i data-lucide="images" class="text-white w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Gallery <span class="text-amber-500">Assets</span></h1>
                    <div class="flex items-center gap-2">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Cloudinary Integrated</p>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-900 hover:text-white transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                Return to Dashboard
            </a>
        </div>
    </div>

    <div class="max-w-[1440px] mx-auto px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- Sidebar: Upload Form -->
            <div class="lg:col-span-3">
                <div class="sticky top-28 space-y-6">
                    <div class="control-card rounded-[2rem] p-8">
                        <h2 class="text-lg font-black text-slate-800 mb-6">Upload Media</h2>

                        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Asset Title</label>
                                <input type="text" name="title" required class="w-full px-5 py-3 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all text-sm font-semibold" placeholder="e.g. Finals 2024">
                            </div>
<div class="space-y-1.5">
    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] ml-1">Description</label>
    <textarea name="description" rows="2"
        class="w-full px-5 py-3.5 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all text-sm font-semibold"
        placeholder="Optional details..."></textarea>
</div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Category</label>
                                <select name="category" class="w-full px-5 py-3 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all text-sm font-semibold">
                                    <option value="Tournaments">Tournaments</option>
                                    <option value="Training">Training</option>
                                    <option value="General">General</option>
                                </select>
                                <p class="text-[9px] text-slate-400 ml-1 italic">* We use description field as category for filtering</p>
                            </div>

                            <div class="relative group">
                                <input type="file" name="image" id="imageInput" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                <div id="dropzone" class="upload-zone rounded-[1.5rem] p-6 bg-slate-50 flex flex-col items-center justify-center text-center">
                                    <div id="previewContainer" class="hidden absolute inset-0 z-10 rounded-[1.5rem] overflow-hidden">
                                        <img id="imagePreview" src="#" class="w-full h-full object-cover">
                                    </div>
                                    <i data-lucide="cloud-lightning" class="text-amber-500 w-8 h-8 mb-2"></i>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase">Select Image</p>
                                </div>
                            </div>

                            <button type="submit" class="btn-primary-dark w-full py-4 rounded-2xl text-white font-black uppercase tracking-widest text-[10px] flex items-center justify-center gap-3">
                                <span>Push to Cloud</span>
                                <i data-lucide="zap" class="w-4 h-4 text-amber-400"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div id="viewWrapper" class="lg:col-span-9">

                <!-- Category Filters (AS PER IMAGE) -->
                <div class="filter-container">
                    <div class="filter-pill all-photos active" onclick="filterGallery('all', this)">All Photos</div>
                    <div class="filter-pill tournaments" onclick="filterGallery('Tournaments', this)">Tournaments</div>
                    <div class="filter-pill training" onclick="filterGallery('Training', this)">Training</div>
                </div>

                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Asset Library</h3>
                        <p class="text-sm font-bold text-slate-800 mt-1">Total: {{ $galleryItems->total() }} items</p>
                    </div>
                    <div class="flex items-center bg-white p-1 rounded-xl border border-slate-200 shadow-sm">
                        <button onclick="switchView('grid')" id="gridBtn" class="p-2.5 rounded-lg active-view transition-all">
                            <i data-lucide="layout-grid" class="w-4 h-4"></i>
                        </button>
                        <button onclick="switchView('list')" id="listBtn" class="p-2.5 rounded-lg text-slate-400 hover:bg-slate-50 transition-all">
                            <i data-lucide="list" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                @if($galleryItems->isEmpty())
                    <div class="bg-white rounded-[3rem] border border-slate-200 border-dashed p-20 text-center">
                        <i data-lucide="image-off" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
                        <h3 class="text-xl font-black text-slate-800">Your library is empty</h3>
                    </div>
                @else
                    <div id="galleryContainer" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 transition-all duration-300">
                        @foreach($galleryItems as $item)
<!-- Added data-category attribute for filtering -->
<div class="asset-card rounded-[2rem] overflow-hidden group" data-category="{{ $item->category }}">
    <div class="img-wrapper relative aspect-[16/10] overflow-hidden bg-slate-100">
        <img src="{{ $item->url }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
            <form action="{{ route('admin.gallery.delete', $item->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Delete permanently?')" class="w-10 h-10 bg-white text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white shadow-xl transition-all">
                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                </button>
            </form>
            <a href="{{ $item->url }}" target="_blank" class="w-10 h-10 bg-white text-slate-900 rounded-xl flex items-center justify-center hover:bg-amber-500 hover:text-white shadow-xl transition-all">
                <i data-lucide="external-link" class="w-5 h-5"></i>
            </a>
        </div>
    </div>

    <div class="card-content-area p-5">
        <div class="card-info flex-1">
            <div class="flex justify-between items-start mb-1">
                <h4 class="text-sm font-black text-slate-800 truncate">{{ $item->title }}</h4>
                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-extrabold uppercase tracking-widest">{{ $item->category ?? 'General' }}</span>
            </div>

            <!-- Description added here -->
            @if($item->description)
                <p class="text-[11px] text-slate-500 font-medium line-clamp-2 mt-1 leading-relaxed">
                    {{ $item->description }}
                </p>
            @else
                <p class="text-[11px] text-slate-300 italic mt-1 leading-relaxed">No description provided</p>
            @endif
        </div>

        <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-300"></i>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">{{ $item->created_at->format('d M Y') }}</span>
            </div>
            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-full text-[9px] font-black uppercase tracking-widest">Active</span>
        </div>
    </div>
</div>
@endforeach
                    </div>

                    <div class="mt-12 flex justify-center">
                        {{ $galleryItems->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    // FILTER LOGIC
    function filterGallery(category, element) {
        // Update Pill UI
        document.querySelectorAll('.filter-pill').forEach(pill => pill.classList.remove('active'));
        element.classList.add('active');

        // Filter Items
        const items = document.querySelectorAll('.asset-card');
        items.forEach(item => {
            const itemCategory = item.getAttribute('data-category');
            if (category === 'all' || itemCategory === category) {
                item.classList.remove('hidden-item');
            } else {
                item.classList.add('hidden-item');
            }
        });
    }

    // VIEW SWITCHER LOGIC
    function switchView(mode) {
        const wrapper = document.getElementById('viewWrapper');
        const gridBtn = document.getElementById('gridBtn');
        const listBtn = document.getElementById('listBtn');

        if (mode === 'list') {
            wrapper.classList.add('view-list');
            listBtn.classList.add('active-view');
            listBtn.classList.remove('text-slate-400');
            gridBtn.classList.remove('active-view');
            gridBtn.classList.add('text-slate-400');
        } else {
            wrapper.classList.remove('view-list');
            gridBtn.classList.add('active-view');
            gridBtn.classList.remove('text-slate-400');
            listBtn.classList.remove('active-view');
            listBtn.classList.add('text-slate-400');
        }
    }

    // Image Preview
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
