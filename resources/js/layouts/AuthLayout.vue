<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { home } from '@/routes';

const { title = '', description = '' } = defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="relative flex min-h-screen items-center justify-center overflow-hidden bg-slate-50 font-sans p-4 sm:p-6 md:p-10 select-none"
    >
        <!-- Background Oranye Glow Blob (Subtle Light Variant) -->
        <div
            class="absolute top-[-10%] right-[-10%] h-[350px] w-[350px] rounded-full bg-brand-orange/10 blur-[100px] opacity-60"
        ></div>
        <div
            class="absolute bottom-[-10%] left-[-10%] h-[350px] w-[350px] rounded-full bg-brand-orange/5 blur-[120px] opacity-50"
        ></div>

        <!-- Dot Grid Pattern Global Background -->
        <div
            class="bg-dot-grid pointer-events-none absolute inset-0 opacity-10"
        ></div>

        <div class="relative z-10 w-full max-w-md">
            <div class="flex flex-col gap-6 md:gap-8">
                <!-- Brand Logo (Sleek Bracket Code style) -->
                <div class="flex flex-col items-center gap-4">
                    <Link
                        :href="home()"
                        class="group flex items-center gap-2.5 font-medium"
                    >
                        <div class="relative flex h-10 w-10 shrink-0 items-center justify-center">
                            <div
                                class="absolute inset-0 rounded-2xl bg-brand-orange/10 opacity-80 blur-[3px] transition duration-300 group-hover:scale-110"
                            ></div>
                            <div
                                class="relative flex h-8.5 w-8.5 items-center justify-center rounded-xl border border-orange-200 bg-white/80 text-brand-orange shadow-sm transition duration-300 group-hover:border-brand-orange/40"
                            >
                                <svg
                                    class="h-4.5 w-4.5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <polyline points="16 18 22 12 16 6" />
                                    <polyline points="8 6 2 12 8 18" />
                                </svg>
                            </div>
                        </div>
                        <span
                            class="font-sans text-xl font-extrabold tracking-tight text-slate-900"
                        >
                            Jasa<span class="text-brand-orange">Web</span><span class="text-brand-orange font-black">.</span>
                        </span>
                    </Link>
                </div>

                <!-- Premium Light Card -->
                <div
                    class="relative overflow-hidden rounded-3xl border border-slate-150/80 bg-white p-6 shadow-xl shadow-slate-200/50 sm:p-8 md:p-10"
                >
                    <!-- Header Info inside Card -->
                    <div class="mb-6 space-y-2 text-center">
                        <h1 class="text-xl font-black tracking-tight text-slate-900 sm:text-2xl">
                            {{ title }}
                        </h1>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            {{ description }}
                        </p>
                    </div>

                    <!-- Slot Content -->
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.bg-dot-grid {
    background-image: radial-gradient(rgba(249, 115, 22, 0.08) 1px, transparent 1px);
    background-size: 24px 24px;
}
</style>
