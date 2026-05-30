<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    LayoutGrid, 
    Plus, 
    Github, 
    Globe, 
    Edit, 
    Trash2, 
    Eye, 
    EyeOff, 
    FolderGit, 
    Layers, 
    User, 
    Sparkles, 
    ChevronRight,
    Loader2,
    X,
    Upload
} from 'lucide-vue-next';

// Define layout and breadcrumbs
defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: '/dashboard',
            },
            {
                title: 'Kelola Projek',
                href: '/dashboard/projects',
            },
        ],
    },
});

// Received properties from controller
const props = defineProps<{
    projects: any[];
}>();

// Form definitions
const form = useForm({
    id: null as number | null,
    github_id: null as number | null,
    name: '' as string,
    title: '' as string,
    client: '' as string,
    category: '' as string,
    description: '' as string,
    github_url: '' as string,
    demo_url: '' as string,
    tech: [] as string[],
    impact: '' as string,
    wa_message: '' as string,
    is_visible: true as boolean,
    order_index: 0 as number,
    image: null as File | null,
});

// UI state variables
const isOpenModal = ref(false);
const isImportModal = ref(false);
const isEdit = ref(false);
const tagInput = ref('');
const githubRepos = ref<any[]>([]);
const isLoadingGithub = ref(false);
const imagePreview = ref<string | null>(null);

// GitHub API Fetcher
const fetchGithubRepos = async () => {
    isLoadingGithub.value = true;
    try {
        const response = await fetch('/dashboard/projects/github-repos');
        if (response.ok) {
            githubRepos.value = await response.json();
        } else {
            alert('Gagal mengambil repositori GitHub.');
        }
    } catch (e) {
        alert('Terjadi kesalahan koneksi.');
    } finally {
        isLoadingGithub.value = false;
    }
};

// Modals management
const openImportModal = () => {
    isImportModal.value = true;
    if (githubRepos.value.length === 0) {
        fetchGithubRepos();
    }
};

const selectRepo = (repo: any) => {
    form.reset();
    form.github_id = repo.id;
    form.name = repo.name;
    form.title = repo.name
        .replace(/[-_]/g, ' ')
        .replace(/\b\w/g, (c: string) => c.toUpperCase());
    form.github_url = repo.html_url;
    form.description = repo.description || '';
    
    if (repo.topics && repo.topics.length > 0) {
        form.tech = repo.topics;
    }
    
    imagePreview.value = null;
    isEdit.value = false;
    isImportModal.value = false;
    isOpenModal.value = true;
};

const openCreateModal = () => {
    isEdit.value = false;
    form.reset();
    imagePreview.value = null;
    isOpenModal.value = true;
};

const openEditModal = (project: any) => {
    isEdit.value = true;
    form.reset();
    form.id = project.id;
    form.github_id = project.github_id;
    form.name = project.name || '';
    form.title = project.title;
    form.client = project.client || '';
    form.category = project.category || '';
    form.description = project.description || '';
    form.github_url = project.github_url || '';
    form.demo_url = project.demo_url || '';
    form.tech = project.tech ? [...project.tech] : [];
    form.impact = project.impact || '';
    form.wa_message = project.wa_message || '';
    form.is_visible = project.is_visible;
    form.order_index = project.order_index;
    form.image = null;
    
    imagePreview.value = project.image_path || null;
    isOpenModal.value = true;
};

// Form submissions
const submitForm = () => {
    if (isEdit.value && form.id) {
        form.post(`/dashboard/projects/${form.id}`, {
            forceFormData: true,
            onSuccess: () => {
                isOpenModal.value = false;
                form.reset();
            },
        });
    } else {
        form.post('/dashboard/projects', {
            forceFormData: true,
            onSuccess: () => {
                isOpenModal.value = false;
                form.reset();
            },
        });
    }
};

const deleteProject = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus projek ini secara permanen?')) {
        form.delete(`/dashboard/projects/${id}`);
    }
};

// Tech tags helpers
const addTechTag = () => {
    const tag = tagInput.value.trim();
    if (tag && !form.tech.includes(tag)) {
        form.tech.push(tag);
    }
    tagInput.value = '';
};

const removeTechTag = (index: number) => {
    form.tech.splice(index, 1);
};

// Image selection preview
const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        const file = target.files[0];
        form.image = file;
        
        // Preview selected image
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};
</script>

<template>
    <Head title="Kelola Projek Portofolio" />

    <div class="flex flex-1 flex-col gap-6 p-6">
        <!-- Top bar intro -->
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white">Kelola Projek Portofolio</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola projek portofolio halaman publik JasaWeb secara dinamis, sinkronisasi dengan GitHub Anda.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <button
                    @click="openImportModal"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition cursor-pointer dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                >
                    <Github class="h-4 w-4 text-brand-orange" />
                    <span>Impor dari GitHub</span>
                </button>
                
                <button
                    @click="openCreateModal"
                    class="inline-flex items-center gap-2 rounded-xl bg-brand-orange px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-brand-orange-dark transition cursor-pointer"
                >
                    <Plus class="h-4 w-4 stroke-[3]" />
                    <span>Tambah Projek</span>
                </button>
            </div>
        </div>

        <!-- Dashboard Alert -->
        <div class="rounded-2xl border border-orange-100 bg-orange-50/50 p-4 dark:border-orange-950/20 dark:bg-orange-950/5">
            <div class="flex gap-3">
                <Sparkles class="h-5 w-5 text-brand-orange shrink-0 mt-0.5" />
                <div class="text-xs text-slate-700 leading-relaxed dark:text-slate-300">
                    <p class="font-bold text-brand-orange mb-0.5">Integrasi GitHub Dinamis</p>
                    <p>Semua projek yang diset sebagai <strong>Tampilkan</strong> akan otomatis muncul di halaman depan JasaWeb, lengkap dengan detail interaktif, WhatsApp chat prompt kustom, dan direct link. Klik tombol <strong>Impor dari GitHub</strong> untuk menyalin data repositori dalam satu klik!</p>
                </div>
            </div>
        </div>

        <!-- Projects Table / Empty State -->
        <div class="rounded-2xl border border-slate-200/80 bg-white shadow-sm overflow-hidden dark:border-slate-800 dark:bg-slate-900">
            <!-- Table Header -->
            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 dark:border-slate-800 dark:bg-slate-900/30">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Daftar Portofolio Projek ({{ projects.length }})</span>
            </div>

            <!-- Empty State -->
            <div v-if="projects.length === 0" class="flex flex-col items-center justify-center py-20 px-6 text-center">
                <FolderGit class="h-16 w-16 text-slate-300 mb-4 stroke-[1.5] animate-pulse" />
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Belum Ada Projek</h3>
                <p class="text-xs text-slate-500 max-w-sm mt-1 leading-relaxed">Impor repositori dari akun GitHub Anda atau tambahkan projek baru secara manual untuk memulainya.</p>
                <button
                    @click="openImportModal"
                    class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-orange px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-brand-orange-dark transition cursor-pointer"
                >
                    <Plus class="h-4 w-4 stroke-[3]" />
                    <span>Impor Projek Pertama Anda</span>
                </button>
            </div>

            <!-- Projects Listing -->
            <div v-else class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:border-slate-800">
                            <th class="px-6 py-3.5">Projek</th>
                            <th class="px-6 py-3.5">Klien & Kategori</th>
                            <th class="px-6 py-3.5">Teknologi</th>
                            <th class="px-6 py-3.5 text-center">Tampilan</th>
                            <th class="px-6 py-3.5 text-center">Urutan</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs dark:divide-slate-800/80">
                        <tr 
                            v-for="project in projects" 
                            :key="project.id"
                            class="hover:bg-slate-50/50 transition dark:hover:bg-slate-800/20"
                        >
                            <!-- Image and Title -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-20 shrink-0 rounded-lg bg-slate-100 border border-slate-200/50 overflow-hidden dark:bg-slate-950 dark:border-slate-800 flex items-center justify-center">
                                        <img 
                                            v-if="project.image_path" 
                                            :src="project.image_path" 
                                            class="h-full w-full object-cover" 
                                            alt="mockup preview"
                                        />
                                        <FolderGit v-else class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <div class="space-y-0.5">
                                        <span class="font-extrabold text-slate-900 dark:text-white text-sm block">{{ project.title }}</span>
                                        <div class="flex items-center gap-2 text-[10px]">
                                            <a v-if="project.github_url" :href="project.github_url" target="_blank" class="inline-flex items-center gap-0.5 text-slate-400 hover:text-brand-orange">
                                                <Github class="h-3 w-3" />
                                                <span>Repo</span>
                                            </a>
                                            <a v-if="project.demo_url" :href="project.demo_url" target="_blank" class="inline-flex items-center gap-0.5 text-slate-400 hover:text-brand-orange">
                                                <Globe class="h-3 w-3" />
                                                <span>Live</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Client and Category -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="space-y-0.5 font-medium">
                                    <span class="text-slate-800 dark:text-slate-200 block">{{ project.client || 'N/A' }}</span>
                                    <span class="text-[10px] text-slate-400 block">{{ project.category || 'N/A' }}</span>
                                </div>
                            </td>

                            <!-- Tech tags -->
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1 max-w-[200px]">
                                    <span 
                                        v-for="tag in (project.tech || [])" 
                                        :key="tag"
                                        class="bg-slate-50 dark:bg-slate-800 text-[9px] font-bold text-slate-500 dark:text-slate-350 px-2 py-0.5 rounded border border-slate-200/40 dark:border-slate-700/50"
                                    >
                                        {{ tag }}
                                    </span>
                                    <span v-if="!project.tech || project.tech.length === 0" class="text-slate-400">Tidak ada</span>
                                </div>
                            </td>

                            <!-- Visibility status -->
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span 
                                    class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[9px] font-extrabold uppercase tracking-wider"
                                    :class="project.is_visible 
                                        ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/20 dark:text-emerald-400' 
                                        : 'bg-slate-50 text-slate-400 dark:bg-slate-800 dark:text-slate-400'"
                                >
                                    <Eye v-if="project.is_visible" class="h-3 w-3" />
                                    <EyeOff v-else class="h-3 w-3" />
                                    <span>{{ project.is_visible ? 'Tampil' : 'Sembunyi' }}</span>
                                </span>
                            </td>

                            <!-- Order index -->
                            <td class="px-6 py-4 text-center font-bold text-slate-800 dark:text-slate-200">
                                {{ project.order_index }}
                            </td>

                            <!-- Action buttons -->
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2.5">
                                    <button 
                                        @click="openEditModal(project)"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-brand-orange hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer"
                                        title="Edit Projek"
                                    >
                                        <Edit class="h-4 w-4" />
                                    </button>
                                    <button 
                                        @click="deleteProject(project.id)"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer"
                                        title="Hapus Projek"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal 1: CRUD Create/Edit Form -->
    <div 
        v-if="isOpenModal" 
        class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-950/60 p-4 backdrop-blur-sm"
        @click.self="isOpenModal = false"
    >
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-850 px-6 py-4">
                <div class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-orange-50 text-brand-orange dark:bg-orange-950/20">
                        <FolderGit class="h-4 w-4" />
                    </span>
                    <h3 class="text-sm font-black text-slate-900 dark:text-white">
                        {{ isEdit ? 'Perbarui Projek Portofolio' : 'Tambah Projek Portofolio Baru' }}
                    </h3>
                </div>
                <button 
                    @click="isOpenModal = false" 
                    class="h-8 w-8 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer"
                >
                    <X class="h-4 w-4" />
                </button>
            </div>

            <!-- Scrollable Body -->
            <form @submit.prevent="submitForm" class="flex-1 overflow-y-auto p-6 space-y-5 text-xs text-slate-700 dark:text-slate-350">
                <!-- Group 1: General Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Judul Tampilan Portofolio *</label>
                        <input 
                            v-model="form.title" 
                            type="text" 
                            required
                            placeholder="Sistem POS Grosir & E-Commerce"
                            class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                        />
                    </div>
                    
                    <div class="space-y-1">
                        <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Nama Klien / Perusahaan</label>
                        <input 
                            v-model="form.client" 
                            type="text" 
                            placeholder="UD Lancar Jaya (Tayu)"
                            class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Kategori Projek</label>
                        <input 
                            v-model="form.category" 
                            type="text" 
                            placeholder="Sistem Internal Kustom / Website Profil"
                            class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                        />
                    </div>
                    
                    <div class="space-y-1">
                        <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Urutan Tampilan</label>
                        <input 
                            v-model.number="form.order_index" 
                            type="number" 
                            required
                            min="0"
                            class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                        />
                    </div>
                </div>

                <!-- Group 2: Tech Tag Input -->
                <div class="space-y-1.5">
                    <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Teknologi Yang Digunakan (Tech Stack)</label>
                    <div class="flex gap-2">
                        <input 
                            v-model="tagInput" 
                            type="text" 
                            placeholder="Laravel 11, Vue 3, Tailwind v4..."
                            @keydown.enter.prevent="addTechTag"
                            class="flex-1 rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                        />
                        <button 
                            type="button" 
                            @click="addTechTag"
                            class="rounded-xl bg-slate-100 hover:bg-slate-200 px-4 text-xs font-bold text-slate-700 transition cursor-pointer dark:bg-slate-800 dark:text-slate-200"
                        >
                            Tambah
                        </button>
                    </div>
                    <div class="flex flex-wrap gap-1.5 pt-1.5">
                        <span 
                            v-for="(tag, index) in form.tech" 
                            :key="tag"
                            class="inline-flex items-center gap-1 bg-orange-50/50 dark:bg-orange-950/20 text-brand-orange dark:text-orange-400 font-extrabold text-[10px] px-2.5 py-1 rounded-lg border border-orange-100/50 dark:border-orange-900/10"
                        >
                            <span>{{ tag }}</span>
                            <button @click="removeTechTag(index)" type="button" class="text-brand-orange hover:text-brand-orange-dark cursor-pointer font-sans text-xs">×</button>
                        </span>
                        <span v-if="form.tech.length === 0" class="text-[10px] text-slate-400 font-medium">Belum ada tag teknologi yang ditambahkan. Tekan Enter untuk menambah.</span>
                    </div>
                </div>

                <!-- Group 3: Links -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400 block flex items-center gap-1">
                            <Github class="h-3.5 w-3.5" />
                            <span>Link Repositori GitHub</span>
                        </label>
                        <input 
                            v-model="form.github_url" 
                            type="url" 
                            placeholder="https://github.com/umamumam/..."
                            class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                        />
                    </div>
                    
                    <div class="space-y-1">
                        <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400 block flex items-center gap-1">
                            <Globe class="h-3.5 w-3.5" />
                            <span>Link Demo Live Website</span>
                        </label>
                        <input 
                            v-model="form.demo_url" 
                            type="url" 
                            placeholder="https://client-demo.com"
                            class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                        />
                    </div>
                </div>

                <!-- Group 4: Mockup Image -->
                <div class="space-y-1.5">
                    <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Mockup Screenshot Portofolio</label>
                    <div class="flex flex-col sm:flex-row gap-4 items-start">
                        <!-- Preview Box -->
                        <div class="h-28 w-44 rounded-xl bg-slate-50 border border-slate-200 overflow-hidden dark:bg-slate-950 dark:border-slate-800 flex items-center justify-center relative shrink-0">
                            <img v-if="imagePreview" :src="imagePreview" class="h-full w-full object-cover" />
                            <div v-else class="text-slate-400 flex flex-col items-center justify-center p-2 text-[10px] text-center">
                                <Upload class="h-5 w-5 mb-1 opacity-60" />
                                <span>No file selected</span>
                            </div>
                        </div>

                        <!-- Upload Actions -->
                        <div class="space-y-2">
                            <label 
                                class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-4 py-2.5 text-xs font-bold text-slate-700 transition cursor-pointer dark:bg-slate-800 dark:text-slate-200"
                            >
                                <Upload class="h-4 w-4" />
                                <span>Pilih File Mockup</span>
                                <input 
                                    type="file" 
                                    accept="image/*"
                                    class="hidden" 
                                    @change="handleImageUpload"
                                />
                            </label>
                            <p class="text-[10px] text-slate-400 leading-normal max-w-sm">Unggah file mockup PNG/JPG berukuran rasio desktop landscape (rekomendasi: 16:10 / 1200x750px) agar tampil premium.</p>
                        </div>
                    </div>
                </div>

                <!-- Group 5: Detailed content -->
                <div class="space-y-1">
                    <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Deskripsi Projek (Description) *</label>
                    <textarea 
                        v-model="form.description" 
                        required
                        rows="3"
                        placeholder="Deskripsikan secara lengkap mengenai fitur utama dan fungsionalitas projek ini..."
                        class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                    ></textarea>
                </div>

                <div class="space-y-1">
                    <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Dampak Nyata / Solusi Yang Dihasilkan (Impact)</label>
                    <input 
                        v-model="form.impact" 
                        type="text" 
                        placeholder="Memotong waktu stock opname dari 3 hari menjadi 30 menit serta menutup celah kebocoran kasir."
                        class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                    />
                </div>

                <div class="space-y-1">
                    <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Pesan WhatsApp Kustom (WA CTA message)</label>
                    <textarea 
                        v-model="form.wa_message" 
                        rows="2"
                        placeholder="Halo JasaWeb Cluwak, saya tertarik untuk bertanya tentang pembuatan projek kustom seperti..."
                        class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                    ></textarea>
                </div>

                <div class="flex items-center gap-3 pt-2 bg-slate-50/50 dark:bg-slate-950/20 p-4 rounded-xl">
                    <input 
                        v-model="form.is_visible" 
                        type="checkbox" 
                        id="visible"
                        class="h-4 w-4 rounded border-slate-300 text-brand-orange focus:ring-brand-orange focus:outline-none cursor-pointer"
                    />
                    <label for="visible" class="font-extrabold text-[10px] uppercase tracking-wider text-slate-600 dark:text-slate-300 cursor-pointer">Tampilkan langsung projek ini di halaman depan portofolio</label>
                </div>

                <!-- Footer Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-850">
                    <button 
                        type="button" 
                        @click="isOpenModal = false" 
                        class="rounded-xl border border-slate-200/80 bg-white hover:bg-slate-50 px-5 py-3 text-xs font-bold text-slate-700 transition cursor-pointer dark:border-slate-850 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-800"
                    >
                        Batal
                    </button>
                    
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="rounded-xl bg-brand-orange hover:bg-brand-orange-dark px-6 py-3 text-xs font-bold text-white shadow-md transition cursor-pointer flex items-center gap-1.5 disabled:opacity-50"
                    >
                        <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                        <span>{{ isEdit ? 'Simpan Perubahan' : 'Tambah Projek' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: GitHub Repository Importer -->
    <div 
        v-if="isImportModal" 
        class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-950/60 p-4 backdrop-blur-sm"
        @click.self="isImportModal = false"
    >
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-2xl w-full max-w-xl overflow-hidden flex flex-col max-h-[80vh]">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-850 px-6 py-4">
                <div class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-slate-50 text-slate-700 dark:bg-slate-800">
                        <Github class="h-4 w-4" />
                    </span>
                    <h3 class="text-sm font-black text-slate-900 dark:text-white">
                        Impor Repositori GitHub (umamumam)
                    </h3>
                </div>
                <button 
                    @click="isImportModal = false" 
                    class="h-8 w-8 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer"
                >
                    <X class="h-4 w-4" />
                </button>
            </div>

            <!-- Loader or List Body -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                <!-- Loader -->
                <div v-if="isLoadingGithub" class="flex flex-col items-center justify-center py-20 text-center gap-3">
                    <Loader2 class="h-10 w-10 text-brand-orange animate-spin" />
                    <span class="text-xs text-slate-500 font-medium">Menghubungkan ke GitHub API...</span>
                </div>

                <!-- Repos listing -->
                <div v-else class="space-y-2.5">
                    <p class="text-xs text-slate-500 mb-2">Pilih salah satu repositori di bawah untuk disalin datanya ke form CRUD secara otomatis.</p>
                    
                    <div 
                        v-for="repo in githubRepos" 
                        :key="repo.id"
                        @click="selectRepo(repo)"
                        class="flex items-center justify-between border border-slate-200/60 rounded-2xl p-4 bg-white hover:border-brand-orange hover:bg-orange-50/5 cursor-pointer transition dark:border-slate-800/80 dark:bg-slate-950 dark:hover:border-orange-500/10"
                    >
                        <div class="space-y-1.5 flex-1 pr-4">
                            <span class="text-xs font-black text-slate-900 dark:text-white block">{{ repo.name }}</span>
                            <p class="text-[10px] text-slate-500 leading-normal line-clamp-2">{{ repo.description || 'Tidak ada deskripsi di repositori GitHub.' }}</p>
                            
                            <div class="flex flex-wrap gap-1" v-if="repo.topics && repo.topics.length > 0">
                                <span 
                                    v-for="topic in repo.topics" 
                                    :key="topic"
                                    class="bg-slate-100 dark:bg-slate-900 text-[8px] font-bold text-slate-400 px-1.5 py-0.5 rounded"
                                >
                                    {{ topic }}
                                </span>
                            </div>
                        </div>
                        <ChevronRight class="h-4 w-4 text-slate-400 shrink-0" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
