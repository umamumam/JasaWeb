<script setup lang="ts">
import { ref } from 'vue';
import { Sparkles, Smartphone, Eye, Check } from 'lucide-vue-next';

// Pilihan Warna Kain Jok (Fabric Colors)
const fabrics = [
    { name: 'Orange Modern', hex: '#ff6c00', class: 'bg-orange-500' },
    { name: 'Royal Blue', hex: '#2563eb', class: 'bg-blue-600' },
    { name: 'Emerald Jati', hex: '#10b981', class: 'bg-emerald-500' },
    { name: 'Classic Charcoal', hex: '#374151', class: 'bg-slate-700' },
    { name: 'Terracotta', hex: '#ea580c', class: 'bg-orange-700' },
];

// Pilihan Finishing Jati (Wood Finishes)
const woods = [
    { name: 'Teak Natural', hex: '#d97706', label: 'Emas Madu' },
    { name: 'Dark Walnut', hex: '#78350f', label: 'Cokelat Klasik' },
    { name: 'Honey Oak', hex: '#b45309', label: 'Kuning Hangat' },
];

const selectedFabric = ref(fabrics[0]);
const selectedWood = ref(woods[0]);
const isARMode = ref(false);

const toggleARMode = () => {
    isARMode.value = !isARMode.value;
};
</script>

<template>
    <div class="glass relative overflow-hidden rounded-3xl border border-slate-200/80 p-6 md:p-8 shadow-xl dark:border-slate-800/40">
        <!-- Dot Grid Accent Inside Simulator -->
        <div class="bg-dot-grid absolute inset-0 -z-10 opacity-70"></div>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <!-- Left Side: Interactive 3D Canvas / Mockup -->
            <div class="lg:col-span-7 flex flex-col items-center justify-center">
                <!-- Main Preview Frame -->
                <div class="relative w-full aspect-[4/3] rounded-2xl bg-gradient-to-b from-slate-100 to-slate-200/50 dark:from-slate-900 dark:to-slate-950/80 flex items-center justify-center p-6 border border-slate-200/40 dark:border-slate-800/50 shadow-inner overflow-hidden">
                    
                    <!-- Living Room Background when AR is toggled -->
                    <Transition
                        enter-active-class="transition duration-500 ease-out"
                        enter-from-class="opacity-0 scale-105"
                        enter-to-class="opacity-100 scale-100"
                        leave-active-class="transition duration-300 ease-in"
                        leave-from-class="opacity-100 scale-100"
                        leave-to-class="opacity-0 scale-105"
                    >
                        <div v-if="isARMode" class="absolute inset-0 z-0">
                            <!-- Simulated living room photo -->
                            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&q=80&w=800');"></div>
                            <!-- Blur Overlay inside a smartphone overlay to simulate AR -->
                            <div class="absolute inset-0 bg-slate-900/10 backdrop-brightness-95"></div>
                            <!-- QR Code Hover Badge -->
                            <div class="absolute top-4 left-4 z-20 glass flex items-center gap-2 px-3 py-1.5 rounded-full text-[10px] font-semibold text-orange-950 dark:text-orange-200 shadow-sm border border-orange-200/20">
                                <Sparkles class="h-3 w-3 text-brand-orange animate-spin" />
                                Mode Simulasi Web AR Aktif
                            </div>
                        </div>
                    </Transition>

                    <!-- Shadow for Sofa (Moves or scales based on selection) -->
                    <div 
                        class="absolute bottom-[22%] left-1/2 -translate-x-1/2 w-[70%] h-[12px] bg-slate-950/20 dark:bg-slate-950/50 rounded-full blur-[6px] transition-all duration-300 z-10"
                        :class="{'bottom-[12%] scale-105 blur-[8px]': isARMode}"
                    ></div>

                    <!-- Luxury Dynamic Sofa SVG (Vector representation that reactive color works beautifully!) -->
                    <svg 
                        viewBox="0 0 400 240" 
                        class="w-[82%] relative z-10 drop-shadow-2xl transition-all duration-500 transform"
                        :class="{'scale-110 translate-y-6': isARMode}"
                    >
                        <!-- Sofa Wooden Frame Parts (Armrests / Legs / Base) -->
                        <!-- Back wooden bars -->
                        <rect x="70" y="55" width="260" height="8" rx="3" :fill="selectedWood.hex" class="transition-colors duration-500" />
                        <rect x="100" y="55" width="12" height="60" :fill="selectedWood.hex" class="opacity-80 transition-colors duration-500" />
                        <rect x="160" y="55" width="12" height="60" :fill="selectedWood.hex" class="opacity-80 transition-colors duration-500" />
                        <rect x="220" y="55" width="12" height="60" :fill="selectedWood.hex" class="opacity-80 transition-colors duration-500" />
                        <rect x="280" y="55" width="12" height="60" :fill="selectedWood.hex" class="opacity-80 transition-colors duration-500" />
                        
                        <!-- Left Wooden Armrest & Leg -->
                        <path d="M40,115 L60,115 L60,195 L48,195 L40,115 Z" :fill="selectedWood.hex" class="transition-colors duration-500" />
                        <rect x="35" y="105" width="30" height="12" rx="4" :fill="selectedWood.hex" class="transition-colors duration-500" />
                        
                        <!-- Right Wooden Armrest & Leg -->
                        <path d="M340,115 L360,115 L360,195 L348,195 L340,115 Z" :fill="selectedWood.hex" class="transition-colors duration-500" />
                        <rect x="335" y="105" width="30" height="12" rx="4" :fill="selectedWood.hex" class="transition-colors duration-500" />
                        
                        <!-- Bottom Front Base Frame -->
                        <rect x="55" y="152" width="290" height="14" rx="2" :fill="selectedWood.hex" class="transition-colors duration-500" />
                        
                        <!-- Cushion: Big Backrest Cushions -->
                        <!-- Cushion 1 -->
                        <rect x="68" y="65" width="128" height="64" rx="8" :fill="selectedFabric.hex" class="transition-colors duration-500" />
                        <rect x="74" y="70" width="116" height="54" rx="6" fill="black" opacity="0.08" />
                        
                        <!-- Cushion 2 -->
                        <rect x="204" y="65" width="128" height="64" rx="8" :fill="selectedFabric.hex" class="transition-colors duration-500" />
                        <rect x="210" y="70" width="116" height="54" rx="6" fill="black" opacity="0.08" />

                        <!-- Cushion: Bottom Seating Cushions -->
                        <rect x="60" y="120" width="280" height="35" rx="10" :fill="selectedFabric.hex" class="transition-colors duration-500" />
                        <rect x="68" y="125" width="264" height="25" rx="8" fill="black" opacity="0.06" />
                        
                        <!-- Decorative Pillows -->
                        <polygon points="75,130 100,105 125,130" :fill="selectedWood.hex" opacity="0.15" />
                        <rect x="80" y="112" width="26" height="26" rx="4" transform="rotate(45 93 125)" fill="#ffffff" opacity="0.35" />
                        <rect x="290" y="112" width="26" height="26" rx="4" transform="rotate(25 303 125)" :fill="selectedFabric.hex" filter="brightness(0.85)" class="transition-colors duration-500" />
                    </svg>

                    <!-- Smartphone AR Simulator Overlay Grid (Mimicking phone camera grid) -->
                    <div v-if="isARMode" class="absolute inset-0 border-[6px] border-slate-900 rounded-2xl flex flex-col justify-between pointer-events-none z-20">
                        <div class="h-6 bg-slate-900 text-white flex items-center justify-between px-4 text-[8px] font-sans">
                            <span>AR CAMERA LENS • LIVE</span>
                            <div class="h-2 w-8 bg-slate-800 rounded-full"></div>
                            <span>82% [Battery]</span>
                        </div>
                        <div class="flex-1 border-[0.5px] border-dashed border-white/20 grid grid-cols-3 grid-rows-3">
                            <div v-for="i in 9" :key="i" class="border-[0.5px] border-dashed border-white/10"></div>
                        </div>
                        <div class="p-2 bg-slate-900/90 text-white text-center text-[9px] font-semibold flex items-center justify-center gap-1.5">
                            <Smartphone class="h-3.5 w-3.5 text-brand-orange animate-bounce" />
                            Gunakan HP Pembeli untuk menaruh mebel di ruangan mereka!
                        </div>
                    </div>
                </div>

                <!-- Simulator Bottom Action -->
                <div class="mt-4 flex gap-4 w-full">
                    <button 
                        @click="toggleARMode"
                        class="flex-1 py-3 px-4 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition duration-300 shadow-md cursor-pointer"
                        :class="isARMode 
                            ? 'bg-slate-900 text-white hover:bg-slate-800 dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-slate-200' 
                            : 'bg-brand-orange text-white hover:bg-brand-orange-dark shadow-orange-500/10'"
                    >
                        <Eye v-if="!isARMode" class="h-4 w-4" />
                        <Smartphone v-else class="h-4 w-4" />
                        {{ isARMode ? 'Kembali ke Studio 3D' : 'Simulasikan Web AR di Ruangan' }}
                    </button>
                </div>
            </div>

            <!-- Right Side: Material Controls & Sales Copy -->
            <div class="lg:col-span-5 flex flex-col justify-between h-full">
                <div>
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-50 text-brand-orange mb-3 dark:bg-orange-950/20 dark:text-orange-400 border border-orange-100 dark:border-orange-900/30">
                        <Sparkles class="h-3.5 w-3.5" />
                        Teknologi Web AR Komersial
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white leading-tight mb-2">
                        Simulasikan Produk Anda di Rumah Pelanggan
                    </h3>
                    
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-6">
                        Cobalah ganti material kain jok dan finishing kayu jati di bawah. Bayangkan pembeli Anda di Jakarta bisa melakukan kustomisasi ini langsung di HP mereka, lalu memproyeksikannya secara 3D di kamar tidur atau ruang tamu mereka!
                    </p>

                    <!-- Control: Fabrics -->
                    <div class="mb-5">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-2.5">
                            Pilihan Kain Jok (Bantalan): <span class="text-brand-orange dark:text-orange-400 font-semibold">{{ selectedFabric.name }}</span>
                        </span>
                        <div class="flex flex-wrap gap-2.5">
                            <button
                                v-for="fabric in fabrics"
                                :key="fabric.name"
                                @click="selectedFabric = fabric"
                                class="h-8 w-8 rounded-full border-2 transition duration-200 hover:scale-110 flex items-center justify-center cursor-pointer shadow-sm"
                                :class="[
                                    fabric.class, 
                                    selectedFabric.name === fabric.name 
                                        ? 'border-slate-800 scale-105 shadow-md dark:border-white' 
                                        : 'border-transparent opacity-80 hover:opacity-100'
                                ]"
                                :title="fabric.name"
                            >
                                <Check v-if="selectedFabric.name === fabric.name" class="h-4 w-4 text-white drop-shadow-sm" />
                            </button>
                        </div>
                    </div>

                    <!-- Control: Wood Finishes -->
                    <div class="mb-6">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-2.5">
                            Jenis Finishing Kayu Jati: <span class="text-brand-orange dark:text-orange-400 font-semibold">{{ selectedWood.name }} ({{ selectedWood.label }})</span>
                        </span>
                        <div class="grid grid-cols-3 gap-2">
                            <button
                                v-for="wood in woods"
                                :key="wood.name"
                                @click="selectedWood = wood"
                                class="border p-2 rounded-xl text-left transition duration-200 hover:bg-slate-50 dark:hover:bg-slate-900/50 cursor-pointer"
                                :class="[
                                    selectedWood.name === wood.name 
                                        ? 'border-brand-orange bg-orange-50/20 text-brand-orange dark:border-orange-500 dark:bg-orange-950/20 dark:text-orange-300 font-bold' 
                                        : 'border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 text-xs'
                                ]"
                            >
                                <div class="flex items-center gap-1.5">
                                    <!-- Dynamic Color Swatch for Wood -->
                                    <span class="h-3 w-3 rounded-full shrink-0 border border-slate-300" :style="{ backgroundColor: wood.hex }"></span>
                                    <span class="text-[10px] leading-none tracking-tight">{{ wood.name }}</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ROI Impact Card -->
                <div class="bg-gradient-to-r from-orange-50 to-amber-50 p-4 rounded-2xl border border-orange-100/50 text-xs dark:from-orange-950/10 dark:to-amber-950/10 dark:border-orange-900/20">
                    <p class="font-bold text-brand-orange-dark dark:text-orange-300 mb-1 flex items-center gap-1">
                        <Sparkles class="h-3.5 w-3.5 text-brand-orange" />
                        Senjata Rahasia Mebel Jepara (+45% Closing Rate)
                    </p>
                    <p class="text-slate-600 dark:text-slate-400 leading-normal">
                        Pembeli dari kota metropolitan sangat ragu membeli mebel ukuran besar secara online karena takut tidak muat di ruangan. Dengan Web AR, mereka bisa mencobanya langsung. Rasa ragu hilang, transfer pun lancar!
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</template>
