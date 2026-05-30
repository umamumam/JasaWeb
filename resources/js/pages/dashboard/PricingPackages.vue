<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    Tag, 
    Plus, 
    Edit, 
    Trash2, 
    Eye, 
    EyeOff, 
    Layers, 
    Sparkles, 
    X,
    TrendingUp,
    PhoneCall,
    Award
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
                title: 'Kelola Harga',
                href: '/dashboard/pricing-packages',
            },
        ],
    },
});

// Received properties from controller
const props = defineProps<{
    packages: any[];
}>();

// Form definitions
const form = useForm({
    id: null as number | null,
    name: '' as string,
    tagline: '' as string,
    price: '' as string,
    slashed_price: '' as string,
    features: [] as string[],
    is_popular: false as boolean,
    wa_text: '' as string,
    order_index: 0 as number,
});

// UI state variables
const isOpenModal = ref(false);
const isEdit = ref(false);
const featureInput = ref('');

const openCreateModal = () => {
    isEdit.value = false;
    form.reset();
    isOpenModal.value = true;
};

const openEditModal = (pkg: any) => {
    isEdit.value = true;
    form.reset();
    form.id = pkg.id;
    form.name = pkg.name;
    form.tagline = pkg.tagline || '';
    form.price = pkg.price;
    form.slashed_price = pkg.slashed_price || '';
    form.features = pkg.features ? [...pkg.features] : [];
    form.is_popular = pkg.is_popular;
    form.wa_text = pkg.wa_text || '';
    form.order_index = pkg.order_index;
    isOpenModal.value = true;
};

// Form submissions
const submitForm = () => {
    if (isEdit.value && form.id) {
        form.put(`/dashboard/pricing-packages/${form.id}`, {
            onSuccess: () => {
                isOpenModal.value = false;
                form.reset();
            },
        });
    } else {
        form.post('/dashboard/pricing-packages', {
            onSuccess: () => {
                isOpenModal.value = false;
                form.reset();
            },
        });
    }
};

const deletePackage = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus paket harga ini secara permanen?')) {
        form.delete(`/dashboard/pricing-packages/${id}`);
    }
};

// Features list helpers
const addFeature = () => {
    const feature = featureInput.value.trim();
    if (feature && !form.features.includes(feature)) {
        form.features.push(feature);
    }
    featureInput.value = '';
};

const removeFeature = (index: number) => {
    form.features.splice(index, 1);
};
</script>

<template>
    <Head title="Kelola Paket Harga & Diskon" />

    <div class="flex flex-1 flex-col gap-6 p-6">
        <!-- Top bar intro -->
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white">Kelola Paket Harga</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola dan kustomisasi paket harga layanan, harga coret diskon, serta detail WhatsApp CTA dinamis.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <button
                    @click="openCreateModal"
                    class="inline-flex items-center gap-2 rounded-xl bg-brand-orange px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-brand-orange-dark transition cursor-pointer"
                >
                    <Plus class="h-4 w-4 stroke-[3]" />
                    <span>Tambah Paket Harga</span>
                </button>
            </div>
        </div>

        <!-- Dashboard Alert -->
        <div class="rounded-2xl border border-orange-100 bg-orange-50/50 p-4 dark:border-orange-950/20 dark:bg-orange-950/5">
            <div class="flex gap-3">
                <Sparkles class="h-5 w-5 text-brand-orange shrink-0 mt-0.5" />
                <div class="text-xs text-slate-700 leading-relaxed dark:text-slate-300">
                    <p class="font-bold text-brand-orange mb-0.5">Pengelolaan Harga Transparan & Diskon</p>
                    <p>Ubah harga, deskripsi tagline, dan berikan <strong>Harga Coret</strong> sebagai penanda diskon menarik. Semua perubahan akan langsung dirender secara real-time di halaman utama publik JasaWeb secara bersih tanpa gambar background yang berantakan.</p>
                </div>
            </div>
        </div>

        <!-- Packages Table / Empty State -->
        <div class="rounded-2xl border border-slate-200/80 bg-white shadow-sm overflow-hidden dark:border-slate-800 dark:bg-slate-900">
            <!-- Table Header -->
            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 dark:border-slate-800 dark:bg-slate-900/30">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Daftar Paket Layanan ({{ packages.length }})</span>
            </div>

            <!-- Empty State -->
            <div v-if="packages.length === 0" class="flex flex-col items-center justify-center py-20 px-6 text-center">
                <Tag class="h-16 w-16 text-slate-300 mb-4 stroke-[1.5] animate-pulse" />
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Belum Ada Paket Harga</h3>
                <p class="text-xs text-slate-500 max-w-sm mt-1 leading-relaxed">Tambahkan paket harga pertama Anda untuk menampilkan tabel harga interaktif di halaman utama.</p>
                <button
                    @click="openCreateModal"
                    class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-orange px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-brand-orange-dark transition cursor-pointer"
                >
                    <Plus class="h-4 w-4 stroke-[3]" />
                    <span>Tambah Paket Pertama</span>
                </button>
            </div>

            <!-- Packages Listing -->
            <div v-else class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:border-slate-800">
                            <th class="px-6 py-3.5">Nama Paket</th>
                            <th class="px-6 py-3.5">Tagline / Deskripsi</th>
                            <th class="px-6 py-3.5">Harga Aktif</th>
                            <th class="px-6 py-3.5">Harga Coret (Diskon)</th>
                            <th class="px-6 py-3.5 text-center">Rekomendasi / Populer</th>
                            <th class="px-6 py-3.5 text-center">Urutan</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs dark:divide-slate-800/80">
                        <tr 
                            v-for="pkg in packages" 
                            :key="pkg.id"
                            class="hover:bg-slate-50/50 transition dark:hover:bg-slate-800/20"
                        >
                            <!-- Name -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg bg-orange-50 text-brand-orange overflow-hidden dark:bg-slate-950 flex items-center justify-center border border-slate-100 dark:border-slate-800">
                                        <Tag class="h-4 w-4" />
                                    </div>
                                    <span class="font-extrabold text-slate-900 dark:text-white text-sm block">{{ pkg.name }}</span>
                                </div>
                            </td>

                            <!-- Tagline -->
                            <td class="px-6 py-4 max-w-xs truncate">
                                <span class="text-slate-600 dark:text-slate-300 font-medium">{{ pkg.tagline || '-' }}</span>
                            </td>

                            <!-- Active Price -->
                            <td class="px-6 py-4 font-extrabold text-slate-900 dark:text-white">
                                {{ pkg.price }}
                            </td>

                            <!-- Slashed Price -->
                            <td class="px-6 py-4 text-slate-400 font-bold">
                                <span v-if="pkg.slashed_price" class="line-through text-slate-400/85">
                                    {{ pkg.slashed_price }}
                                </span>
                                <span v-else class="text-slate-300 dark:text-slate-700">-</span>
                            </td>

                            <!-- Popularity status -->
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span 
                                    class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[9px] font-extrabold uppercase tracking-wider"
                                    :class="pkg.is_popular 
                                        ? 'bg-amber-50 text-amber-600 dark:bg-amber-950/20 dark:text-amber-400' 
                                        : 'bg-slate-50 text-slate-400 dark:bg-slate-800 dark:text-slate-400'"
                                >
                                    <Award class="h-3 w-3" />
                                    <span>{{ pkg.is_popular ? 'Populer' : 'Standard' }}</span>
                                </span>
                            </td>

                            <!-- Order index -->
                            <td class="px-6 py-4 text-center font-bold text-slate-850 dark:text-slate-200">
                                {{ pkg.order_index }}
                            </td>

                            <!-- Action buttons -->
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2.5">
                                    <button 
                                        @click="openEditModal(pkg)"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-brand-orange hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer"
                                        title="Edit Paket"
                                    >
                                        <Edit class="h-4 w-4" />
                                    </button>
                                    <button 
                                        @click="deletePackage(pkg.id)"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer"
                                        title="Hapus Paket"
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

    <!-- Modal: CRUD Create/Edit Form -->
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
                        <Tag class="h-4 w-4" />
                    </span>
                    <h3 class="text-sm font-black text-slate-900 dark:text-white">
                        {{ isEdit ? 'Perbarui Paket Layanan' : 'Tambah Paket Layanan Baru' }}
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
                        <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Nama Paket Layanan *</label>
                        <input 
                            v-model="form.name" 
                            type="text" 
                            required
                            placeholder="Paket Starter / Paket Premium"
                            class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                        />
                    </div>
                    
                    <div class="space-y-1">
                        <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Tagline / Deskripsi Singkat</label>
                        <input 
                            v-model="form.tagline" 
                            type="text" 
                            placeholder="Layanan Web Profesional JasaWeb, Harga Transparan"
                            class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-955 dark:text-white"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Harga Aktif (Saat Ini) *</label>
                        <input 
                            v-model="form.price" 
                            type="text" 
                            required
                            placeholder="Rp 2.999.000 atau Harga Kustom"
                            class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                        />
                    </div>
                    
                    <div class="space-y-1">
                        <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400 block flex items-center gap-1">
                            <span class="text-rose-500 line-through">Harga Coret</span>
                            <span>(Diskon - Opsional)</span>
                        </label>
                        <input 
                            v-model="form.slashed_price" 
                            type="text" 
                            placeholder="Rp 3.500.000"
                            class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    
                    <div class="space-y-1.5 flex flex-col justify-end pb-1.5">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input 
                                v-model="form.is_popular" 
                                type="checkbox"
                                class="rounded border-slate-300 text-brand-orange focus:ring-brand-orange h-4 w-4"
                            />
                            <span class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Tandai Sebagai Terpopuler / Direkomendasikan</span>
                        </label>
                    </div>
                </div>

                <!-- Group 2: Features Manager -->
                <div class="space-y-1.5">
                    <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400">Fitur Yang Ditawarkan *</label>
                    <div class="flex gap-2">
                        <input 
                            v-model="featureInput" 
                            type="text" 
                            placeholder="5 Halaman Web, Gratis Hosting 1 Tahun, Desain Kustom..."
                            @keydown.enter.prevent="addFeature"
                            class="flex-1 rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                        />
                        <button 
                            type="button" 
                            @click="addFeature"
                            class="rounded-xl bg-slate-100 hover:bg-slate-200 px-4 text-xs font-bold text-slate-700 transition cursor-pointer dark:bg-slate-800 dark:text-slate-200"
                        >
                            Tambah
                        </button>
                    </div>
                    <div class="flex flex-col gap-1.5 pt-1.5">
                        <div 
                            v-for="(feature, index) in form.features" 
                            :key="feature"
                            class="inline-flex items-center justify-between bg-slate-50 dark:bg-slate-850 px-3 py-2 rounded-xl border border-slate-150/40 dark:border-slate-800"
                        >
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ feature }}</span>
                            <button @click="removeFeature(index)" type="button" class="text-rose-500 hover:text-rose-600 cursor-pointer font-sans text-xs">Hapus</button>
                        </div>
                        <span v-if="form.features.length === 0" class="text-[10px] text-slate-400 font-medium">Belum ada fitur yang ditambahkan. Tekan Enter untuk menambah.</span>
                    </div>
                </div>

                <!-- Group 3: WhatsApp custom text -->
                <div class="space-y-1">
                    <label class="font-extrabold text-[10px] uppercase tracking-wider text-slate-400 block flex items-center gap-1">
                        <PhoneCall class="h-3.5 w-3.5 text-brand-orange" />
                        <span>Kustom Pesan WhatsApp</span>
                    </label>
                    <textarea 
                        v-model="form.wa_text" 
                        rows="3"
                        placeholder="Halo JasaWeb Cluwak, saya tertarik untuk memesan Paket..."
                        class="w-full rounded-xl border border-slate-200/80 bg-white px-3.5 py-2.5 text-xs font-semibold focus:border-brand-orange focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:text-white"
                    ></textarea>
                </div>

                <!-- Action Footer inside Form -->
                <div class="border-t border-slate-100 dark:border-slate-850 pt-4 flex justify-end gap-3">
                    <button 
                        type="button" 
                        @click="isOpenModal = false"
                        class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 font-bold text-slate-700 transition cursor-pointer dark:border-slate-850 dark:bg-slate-950 dark:text-slate-350 dark:hover:bg-slate-800"
                    >
                        Batalkan
                    </button>
                    <button 
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-xl bg-brand-orange px-6 py-2.5 font-bold text-white shadow-sm hover:bg-brand-orange-dark transition cursor-pointer flex items-center gap-1.5"
                    >
                        <span v-if="form.processing" class="h-4 w-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        <span>{{ isEdit ? 'Simpan Perubahan' : 'Tambah Paket Harga' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
