<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { X, Send } from 'lucide-vue-next';

const isOpen = ref(false);
const showNotification = ref(false);
const customMessage = ref('');

// Nomor WA resmi Anda
const whatsappNumber = '6285799352991'; // Format internasional tanpa '+' atau spasi

const toggleChat = () => {
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
        showNotification.value = false;
    }
};

const templates = [
    {
        label: 'Tanya Jasa Website (Pati)',
        text: 'Halo Mas, saya pelaku usaha dari Pati. Ingin bertanya tentang Jasa Pembuatan Website berkualitas dengan desain oranye premium Karma. Bisa kirim infonya?',
    },
    {
        label: 'Tanya Sistem Kasir & Stok Gudang',
        text: 'Halo JasaWeb, saya ingin bertanya tentang Sistem Kasir & Manajemen Stok kustom untuk bisnis saya di Pati/Jepara. Ingin tanya skema & biayanya.',
    },
    {
        label: 'Jadwalkan Demo/Bertemu Langsung',
        text: 'Halo, saya ingin konsultasi langsung tatap muka. Posisi saya di [Nama Daerah]. Kapan ada waktu luang untuk berkunjung ke kantor/gudang kami?',
    },
];

const sendToWhatsApp = (text: string) => {
    const encodedText = encodeURIComponent(text);
    const url = `https://api.whatsapp.com/send?phone=${whatsappNumber}&text=${encodedText}`;
    window.open(url, '_blank');
};

const handleCustomSend = () => {
    if (!customMessage.value.trim()) return;
    sendToWhatsApp(customMessage.value);
    customMessage.value = '';
};

onMounted(() => {
    // Tampilkan notifikasi balon kecil setelah 4 detik untuk memancing perhatian
    setTimeout(() => {
        if (!isOpen.value) {
            showNotification.value = true;
        }
    }, 4000);
});
</script>

<template>
    <div class="fixed right-6 bottom-6 z-50 font-sans select-none">
        <!-- Floating Chat Window -->
        <Transition
            enter-active-class="transition duration-300 ease-out transform"
            enter-from-class="opacity-0 translate-y-8 scale-95"
            enter-to-class="opacity-100 translate-y-0 scale-100"
            leave-active-class="transition duration-200 ease-in transform"
            leave-from-class="opacity-100 translate-y-0 scale-100"
            leave-to-class="opacity-0 translate-y-8 scale-95"
        >
            <div
                v-if="isOpen"
                class="glass mb-4 w-[340px] overflow-hidden rounded-2xl border border-orange-100 shadow-2xl md:w-[360px] dark:border-orange-900/30"
            >
                <!-- Header (Karma Orange Style) -->
                <div class="bg-brand-orange p-4 text-white dark:bg-brand-orange-dark shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <!-- Avatar -->
                            <div class="relative h-10 w-10 overflow-hidden rounded-full border border-orange-200 bg-orange-100 dark:border-orange-700">
                                <span class="flex h-full w-full items-center justify-center font-bold text-brand-orange dark:text-orange-200">
                                    JW
                                </span>
                                <!-- Online Status Indicator -->
                                <span class="absolute right-0 bottom-0 block h-2.5 w-2.5 rounded-full bg-emerald-400 ring-2 ring-white dark:ring-slate-900"></span>
                            </div>
                            <!-- Title -->
                            <div>
                                <h4 class="font-bold leading-tight">JasaWeb Developer</h4>
                                <p class="text-xs text-orange-100">Pati Kota • Aktif (Online)</p>
                            </div>
                        </div>
                        <button
                            @click="toggleChat"
                            class="rounded-full p-1.5 text-white/80 hover:bg-white/10 hover:text-white transition"
                        >
                            <X class="h-5 w-5" />
                        </button>
                    </div>
                </div>

                <!-- Chat Body Area -->
                <div class="bg-dot-grid max-h-[300px] overflow-y-auto bg-slate-50/55 p-4 dark:bg-slate-950/45">
                    <!-- Message from Developer -->
                    <div class="mb-4 flex items-start gap-2.5">
                        <div class="rounded-2xl rounded-tl-none bg-white p-3.5 shadow-sm border border-slate-100 text-sm leading-relaxed text-slate-700 dark:bg-slate-900 dark:border-slate-800/80 dark:text-slate-300">
                            <p class="font-medium text-brand-orange mb-1 dark:text-brand-orange">Mas Dev • JasaWeb</p>
                            Halo! Saya siap meluncur langsung ke lokasi Anda di Pati / Jepara untuk tatap muka. Ada yang bisa dibantu untuk pembuatan website atau sistem kasir kustom Anda hari ini? ☕
                        </div>
                    </div>

                    <!-- Templates / Quick Options -->
                    <div class="space-y-2">
                        <p class="text-[11px] font-semibold tracking-wider text-slate-400 uppercase mb-1">Pertanyaan Cepat:</p>
                        <button
                            v-for="(tpl, idx) in templates"
                            :key="idx"
                            @click="sendToWhatsApp(tpl.text)"
                            class="w-full text-left rounded-xl border border-orange-100/80 bg-orange-50/30 p-2.5 text-xs font-medium text-brand-orange-dark hover:bg-orange-50 dark:border-orange-900/20 dark:bg-orange-950/10 dark:text-orange-300 dark:hover:bg-orange-950/30 transition text-wrap leading-normal"
                        >
                            {{ tpl.label }}
                        </button>
                    </div>
                </div>

                <!-- Footer (Text Input) -->
                <div class="border-t border-slate-100 bg-white p-3 dark:border-slate-900 dark:bg-slate-900">
                    <form @submit.prevent="handleCustomSend" class="flex items-center gap-2">
                        <input
                            v-model="customMessage"
                            type="text"
                            placeholder="Ketik pertanyaan kustom di sini..."
                            class="flex-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs focus:border-brand-orange focus:bg-white focus:outline-none dark:border-slate-800 dark:bg-slate-950 dark:focus:border-brand-orange"
                        />
                        <button
                            type="submit"
                            class="flex h-8 w-8 items-center justify-center rounded-xl bg-whatsapp text-white hover:bg-whatsapp-dark transition shadow-sm"
                        >
                            <Send class="h-4 w-4" />
                        </button>
                    </form>
                </div>
            </div>
        </Transition>

        <!-- Floating Button -->
        <button
            @click="toggleChat"
            class="group relative flex h-14 w-14 items-center justify-center rounded-full bg-whatsapp text-white shadow-lg shadow-emerald-500/20 transition duration-300 hover:scale-105 active:scale-95 cursor-pointer dark:shadow-emerald-950/20"
        >
            <!-- Pulse Ring for Attracting Click -->
            <span class="absolute inset-0 -z-10 rounded-full bg-whatsapp/40 animate-ping group-hover:animate-none"></span>

            <!-- Official WhatsApp Logo SVG -->
            <svg 
                v-if="!isOpen"
                xmlns="http://www.w3.org/2000/svg" 
                viewBox="0 0 448 512" 
                class="h-7 w-7 fill-current transition-transform group-hover:rotate-6"
            >
                <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
            </svg>
            <X v-else class="h-6 w-6" />

            <!-- Unread Notification Badge -->
            <span
                v-if="showNotification && !isOpen"
                class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white animate-bounce"
            >
                1
            </span>
        </button>
    </div>
</template>
