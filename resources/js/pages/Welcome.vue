<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import {
    TrendingUp,
    ShieldCheck,
    Sparkles,
    MapPin,
    Zap,
    GraduationCap,
    ArrowRight,
    CheckCircle2,
    ChevronDown,
    Award,
    Search,
    ShoppingBag,
    Plus,
    PhoneCall,
    X,
    ExternalLink,
    Layers,
    Lock,
    Eye,
    Github,
    Mail,
    Clock,
    Send,
    Globe,
    Terminal,
} from 'lucide-vue-next';
import { animate } from 'animejs';

// Import Custom Components
import ARSimulator from '@/components/ARSimulator.vue';
import WhatsAppCTA from '@/components/WhatsAppCTA.vue';

const whatsappNumber = '6285799352991';
const startConsultationText =
    'Halo JasaWeb Cluwak, saya tertarik untuk konsultasi gratis mengenai pembuatan website/sistem untuk bisnis saya...';
const directWaUrl = `https://api.whatsapp.com/send?phone=${whatsappNumber}&text=${encodeURIComponent(startConsultationText)}`;

// Interactive Contact Form state
const contactForm = ref({
    name: '',
    service: 'Website Profil Bisnis (Company Profile)',
    message: '',
});

// Build custom WhatsApp pre-filled text and redirect klien
const submitContactToWa = () => {
    const formattedText = `Halo JasaWeb Cluwak, nama saya *${contactForm.value.name}*.\nSaya tertarik dengan layanan *${contactForm.value.service}*.\n\n*Detail Proyek/Kebutuhan*:\n${contactForm.value.message || '-'}`;
    const targetUrl = `https://api.whatsapp.com/send?phone=${whatsappNumber}&text=${encodeURIComponent(formattedText)}`;
    window.open(targetUrl, '_blank');
};

const scrollY = ref(0);
const isScrolled = ref(false);
const activeSection = ref('home');

const setActiveSection = (sectionId: string) => {
    activeSection.value = sectionId;
};

const handleScroll = () => {
    scrollY.value = window.scrollY;
    isScrolled.value = window.scrollY > 30;

    // Scroll Spy: dynamically highlight the active section in view
    const sectionIds = [
        'home',
        'tentang-kami',
        'projek',
        'kenapa-kami',
        'pricing',
        'kontak',
    ];
    let currentActive = 'home';

    for (const id of sectionIds) {
        const el = document.getElementById(id);
        if (el) {
            const rect = el.getBoundingClientRect();
            // Trigger active state when section takes up the central threshold
            if (rect.top <= 150 && rect.bottom >= 150) {
                currentActive = id;
                break;
            }
        }
    }

    // Boundary/Fallback cases
    if (
        window.innerHeight + window.scrollY >=
        document.documentElement.scrollHeight - 50
    ) {
        currentActive = 'kontak';
    } else if (window.scrollY < 80) {
        currentActive = 'home';
    }

    activeSection.value = currentActive;
};

// 3D Parallax properties for the Hero coder image
const heroRotateY = computed(() => {
    return Math.min(20, scrollY.value * 0.05);
});

const heroRotateX = computed(() => {
    return Math.min(8, scrollY.value * 0.02);
});

const heroTranslateY = computed(() => {
    return scrollY.value * 0.12;
});

// Projects Showcase Data (Exactly 6 Projects for a 3-column, 2-row grid)
// Define props received from backend controller
const props = defineProps<{
    projects: any[];
    pricing_packages: any[];
}>();

const projects = computed(() => {
    return (props.projects || []).map((project) => ({
        ...project,
        image: project.image_path,
        waMessage: project.wa_message,
    }));
});

const selectedProject = ref<any | null>(null);

const openProject = (project: any) => {
    selectedProject.value = project;
    document.body.style.overflow = 'hidden'; // Lock background scroll
};

const closeProject = () => {
    selectedProject.value = null;
    document.body.style.overflow = ''; // Release background scroll
};

// Dynamic Pricing Packages from Database
const pricingPackages = computed(() => {
    return (props.pricing_packages || []).map((pkg) => ({
        name: pkg.name,
        tagline: pkg.tagline,
        price: pkg.price,
        slashedPrice: pkg.slashed_price,
        features: pkg.features || [],
        popular: pkg.is_popular,
        waText: pkg.wa_text || '',
    }));
});

const getWaLink = (text: string) => {
    return `https://api.whatsapp.com/send?phone=${whatsappNumber}&text=${encodeURIComponent(text)}`;
};

// Intersection Observer for scroll entrance transitions
let scrollObserver: IntersectionObserver | null = null;

const setupScrollObserver = () => {
    scrollObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                }
            });
        },
        {
            threshold: 0.05,
            rootMargin: '0px 0px -40px 0px',
        },
    );

    document
        .querySelectorAll(
            '.reveal-element, .reveal-element-left, .reveal-element-right, .reveal-element-scale',
        )
        .forEach((el) => {
            scrollObserver?.observe(el);
        });
};

// Anime.js Interactive Hover Parallax for About Us Collage Layers
const isHoveringAbout = ref(false);

const handleAboutMouseEnter = () => {
    isHoveringAbout.value = true;
    animate('.about-main-img', {
        scale: 1.03,
        translateY: -5,
        translateX: 5,
        duration: 800,
        ease: 'outQuad',
    });
    animate('.about-badge', {
        scale: 1.08,
        rotateZ: 3,
        translateX: -5,
        translateY: -5,
        duration: 800,
        ease: 'outQuad',
    });
    animate('.about-secondary-img-wrapper', {
        scale: 1.08,
        translateX: 12,
        translateY: 12,
        duration: 800,
        ease: 'outQuad',
    });
};

const handleAboutMouseLeave = () => {
    isHoveringAbout.value = false;
    animate('.about-main-img', {
        scale: 1,
        translateY: 0,
        translateX: 0,
        duration: 800,
        ease: 'outQuad',
    });
    animate('.about-badge', {
        scale: 1,
        rotateZ: 0,
        translateX: 0,
        translateY: 0,
        duration: 800,
        ease: 'outQuad',
    });
    animate('.about-secondary-img-wrapper', {
        scale: 1,
        translateX: 0,
        translateY: 0,
        duration: 800,
        ease: 'outQuad',
    });
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    handleScroll();
    setTimeout(() => {
        setupScrollObserver();
    }, 200);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    if (scrollObserver) {
        scrollObserver.disconnect();
    }
});
</script>

<template>
    <Head>
        <title>
            Jasa Website &amp; Augmented Reality (AR) Pati, Jepara, Kudus -
            JasaWeb
        </title>
        <meta
            name="description"
            content="Mitra pengembang website profesional, sistem kasir/ERP kustom, dan Augmented Reality (AR) terpercaya di wilayah Pati, Jepara, Kudus. Hubungi kami untuk konsultasi gratis!"
        />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin="anonymous"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:wght@400;500;600;700;800;900&display=swap"
            rel="stylesheet"
        />
    </Head>

    <div
        class="min-h-screen bg-slate-50 text-slate-800 transition-colors duration-300 selection:bg-brand-orange selection:text-white dark:bg-slate-950 dark:text-slate-100"
    >
        <!-- Dot Grid Pattern Global Background -->
        <div
            class="bg-dot-grid pointer-events-none absolute inset-0 -z-20 opacity-60"
        ></div>

        <!-- Floating Sticky Header / Navigation (Karma Style) -->
        <div
            class="pointer-events-none sticky top-0 z-40 w-full transition-all duration-500 ease-in-out"
            :class="isScrolled ? 'px-0 pt-0' : 'px-6 pt-4 lg:pt-6'"
        >
            <header
                class="pointer-events-auto mx-auto flex items-center justify-between bg-white transition-all duration-500 ease-in-out dark:bg-slate-900"
                :class="
                    isScrolled
                        ? 'max-w-full rounded-none border-x-0 border-t-0 border-b border-slate-200/50 px-6 py-3 shadow-md lg:px-16 dark:border-slate-800/80'
                        : 'shadow-karma max-w-7xl rounded-2xl border border-slate-100 px-6 py-3.5 lg:px-10 dark:border-slate-800/50'
                "
            >
                <!-- Brand Logo (Karma-style Orange Badge) -->
                <a href="#home" class="group flex items-center gap-2.5">
                    <div class="relative flex h-10 w-10 shrink-0 items-center justify-center">
                        <div
                            class="absolute inset-0 rounded-2xl bg-brand-orange/10 opacity-80 blur-[3px] transition duration-300 group-hover:scale-110"
                        ></div>
                        <div
                            class="relative flex h-8.5 w-8.5 items-center justify-center rounded-xl border border-orange-200/60 bg-white/70 text-brand-orange shadow-sm transition duration-300 dark:border-orange-500/20 dark:bg-slate-900/60"
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
                        class="font-sans text-xl font-extrabold tracking-tight text-brand-slate dark:text-white"
                    >
                        Jasa<span class="text-brand-orange">Web</span><span class="text-brand-orange font-black">.</span>
                    </span>
                </a>

                <!-- Desktop Navigation Menu (Poppins Uppercase) -->
                <nav
                    class="hidden items-center gap-8 font-sans text-[11px] font-bold tracking-wider text-slate-700 uppercase md:flex dark:text-slate-300"
                >
                    <a
                        href="#home"
                        @click="setActiveSection('home')"
                        class="font-sans transition"
                        :class="
                            activeSection === 'home'
                                ? 'text-brand-orange'
                                : 'hover:text-brand-orange'
                        "
                        >Home</a
                    >
                    <a
                        href="#tentang-kami"
                        @click="setActiveSection('tentang-kami')"
                        class="font-sans transition"
                        :class="
                            activeSection === 'tentang-kami'
                                ? 'text-brand-orange'
                                : 'hover:text-brand-orange'
                        "
                        >Tentang Kami</a
                    >
                    <a
                        href="#projek"
                        @click="setActiveSection('projek')"
                        class="font-sans transition"
                        :class="
                            activeSection === 'projek'
                                ? 'text-brand-orange'
                                : 'hover:text-brand-orange'
                        "
                        >Projek</a
                    >
                    <a
                        href="#kenapa-kami"
                        @click="setActiveSection('kenapa-kami')"
                        class="font-sans transition"
                        :class="
                            activeSection === 'kenapa-kami'
                                ? 'text-brand-orange'
                                : 'hover:text-brand-orange'
                        "
                        >Keunggulan</a
                    >
                    <a
                        href="#kontak"
                        @click="setActiveSection('kontak')"
                        class="font-sans transition"
                        :class="
                            activeSection === 'kontak'
                                ? 'text-brand-orange'
                                : 'hover:text-brand-orange'
                        "
                        >Hubungi Kami</a
                    >
                </nav>

                <!-- Right Side: Contact WA Link -->
                <div class="pointer-events-auto flex items-center gap-5">
                    <a
                        :href="directWaUrl"
                        target="_blank"
                        class="flex cursor-pointer items-center gap-2 rounded-xl bg-brand-orange px-4 py-2 text-xs font-bold text-white shadow-md transition duration-300 hover:scale-103 hover:bg-brand-orange-dark"
                    >
                        <PhoneCall class="h-3.5 w-3.5" />
                        <span>Konsultasi WA</span>
                    </a>
                </div>
            </header>
        </div>

        <!-- Main Content -->
        <main>
            <!-- Hero Section (Karma Shop Stripe Design) -->
            <section
                id="home"
                class="relative flex min-h-[580px] items-center overflow-hidden bg-cover bg-center bg-no-repeat pt-8 pb-20 md:py-24"
                style="background-image: url('/banner-bg.jpg')"
            >
                <div
                    class="relative z-10 mx-auto grid w-full max-w-7xl grid-cols-1 items-center gap-12 px-6 lg:grid-cols-12"
                >
                    <!-- Hero Texts (Left Side) -->
                    <div
                        class="reveal-element-left space-y-6 text-center lg:col-span-7 lg:text-left"
                    >
                        <!-- Badge -->
                        <div
                            class="inline-flex items-center gap-1.5 rounded-full border border-orange-100 bg-orange-50 px-3 py-1 text-xs font-bold text-brand-orange dark:border-orange-900/30 dark:bg-orange-950/20 dark:text-orange-400"
                        >
                            <MapPin class="h-3.5 w-3.5" />
                            Mitra Web Developer &amp; Augmented Reality (AR) —
                            Pati, Jepara, Kudus
                        </div>

                        <!-- Headline (Bold Poppins, Karma-Style Title) -->
                        <h1
                            class="text-3xl leading-[1.08] font-black tracking-tight text-brand-slate sm:text-4xl md:text-5xl lg:text-[56px] dark:text-white"
                        >
                            Website Keren,<br />
                            <span class="text-brand-orange">Omzet Nanjak!</span>
                        </h1>

                        <!-- Sub-headline -->
                        <p
                            class="mx-auto max-w-xl text-xs leading-relaxed font-medium text-slate-600 sm:text-sm lg:mx-0 dark:text-slate-300"
                        >
                            Mitra pengembang website profesional, sistem
                            kasir/ERP kustom, dan Augmented Reality (AR)
                            terpercaya di wilayah Pati, Jepara, Kudus. Dapatkan
                            solusi digital berkinerja tinggi untuk memperluas
                            jangkauan pasar bisnis Anda secara aman dengan
                            pembayaran bertahap.
                        </p>

                        <!-- Key Multipliers / Local Trust Badges -->
                        <div
                            class="mx-auto grid max-w-xl grid-cols-1 gap-3 pt-2 text-left sm:grid-cols-3 lg:mx-0"
                        >
                            <div
                                class="flex items-center gap-2 rounded-xl border border-slate-100 bg-white p-2.5 shadow-sm dark:border-slate-800/80 dark:bg-slate-900"
                            >
                                <ShieldCheck
                                    class="h-5 w-5 shrink-0 text-emerald-500"
                                />
                                <span
                                    class="text-[10px] leading-tight font-bold"
                                    >Bayar Bertahap (Aman dari Tipu)</span
                                >
                            </div>
                            <div
                                class="flex items-center gap-2 rounded-xl border border-slate-100 bg-white p-2.5 shadow-sm dark:border-slate-800/80 dark:bg-slate-900"
                            >
                                <Zap
                                    class="h-5 w-5 shrink-0 animate-pulse text-brand-orange"
                                />
                                <span
                                    class="text-[10px] leading-tight font-bold"
                                    >Akses Cepat Sinyal Pelosok</span
                                >
                            </div>
                            <div
                                class="flex items-center gap-2 rounded-xl border border-slate-100 bg-white p-2.5 shadow-sm dark:border-slate-800/80 dark:bg-slate-900"
                            >
                                <GraduationCap
                                    class="h-5 w-5 shrink-0 text-brand-orange"
                                />
                                <span
                                    class="text-[10px] leading-tight font-bold"
                                    >Tatap Muka &amp; Training Langsung</span
                                >
                            </div>
                        </div>

                        <!-- CTA Buttons (Official Karma Circle Plus Design) -->
                        <div
                            class="flex flex-col items-center justify-center gap-6 pt-4 sm:flex-row lg:justify-start"
                        >
                            <!-- Circular Plus Button CTA -->
                            <a
                                :href="directWaUrl"
                                target="_blank"
                                class="group flex w-full cursor-pointer items-center gap-4 transition duration-300 hover:scale-102 sm:w-auto"
                            >
                                <div
                                    class="shadow-karma flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-brand-orange text-2xl font-bold text-white transition group-hover:bg-brand-orange-dark"
                                >
                                    <Plus class="h-6 w-6 stroke-[3]" />
                                </div>
                                <div class="text-left">
                                    <span
                                        class="block text-sm font-extrabold tracking-wider text-slate-800 uppercase transition group-hover:text-brand-orange dark:text-white"
                                    >
                                        Mulai Tanya WA
                                    </span>
                                    <span
                                        class="block text-[10px] font-semibold text-slate-400"
                                        >Konsultasi Desain &amp; Fitur
                                        Gratis</span
                                    >
                                </div>
                            </a>

                            <!-- Secondary Text Button -->
                            <a
                                href="#projek"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-6 py-4 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 sm:w-auto dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                            >
                                Lihat Portofolio
                                <ArrowRight class="h-4 w-4" />
                            </a>
                        </div>
                    </div>

                    <!-- Hero Visual (Animated Coder Coding Illustration - Right Side) -->
                    <div
                        class="reveal-element-right relative flex items-center justify-center lg:col-span-5"
                    >
                        <div
                            class="relative flex aspect-[4/3] w-full max-w-[440px] translate-x-6 transform items-center justify-center transition-transform duration-100 ease-out lg:translate-x-12"
                            :style="{
                                transform:
                                    'perspective(1000px) rotateY(' +
                                    heroRotateY +
                                    'deg) rotateX(-' +
                                    heroRotateX +
                                    'deg) translateY(' +
                                    heroTranslateY +
                                    'px)',
                                willChange: 'transform',
                            }"
                        >
                            <!-- Premium Glow behind coder -->
                            <div
                                class="animate-pulse-soft pointer-events-none absolute -inset-4 rounded-full bg-gradient-to-tr from-brand-orange/15 to-amber-500/15 opacity-60 blur-2xl"
                            ></div>

                            <!-- Seamless Transparent Coder Image -->
                            <img
                                src="/programmer.png"
                                alt="Programer JasaWeb sedang coding sistem"
                                class="h-auto w-full object-contain drop-shadow-2xl transition duration-500 hover:scale-102"
                            />
                        </div>
                    </div>
                </div>
            </section>

            <!-- Seksi Tentang Kami (About Us) -->
            <section
                id="tentang-kami"
                class="relative overflow-hidden bg-white py-20 md:py-28 dark:bg-slate-950"
            >
                <!-- Dot Grid Accent Background -->
                <div
                    class="bg-dot-grid absolute inset-0 -z-10 opacity-30"
                ></div>

                <!-- Background Decorative Blob -->
                <div
                    class="pointer-events-none absolute top-1/4 -left-36 h-[350px] w-[350px] rounded-full bg-brand-orange/10 opacity-50 blur-3xl"
                ></div>

                <div
                    class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 px-6 lg:grid-cols-12 lg:gap-16"
                >
                    <!-- Sisi Kiri: Kolase Gambar Berlapis -->
                    <div
                        class="reveal-element-left relative flex justify-center select-none lg:col-span-5 lg:justify-start"
                        @mouseenter="handleAboutMouseEnter"
                        @mouseleave="handleAboutMouseLeave"
                    >
                        <div
                            class="relative flex aspect-square w-full max-w-[420px] items-center justify-center p-6"
                        >
                            <!-- Lapisan 1: Gambar Utama -->
                            <div
                                class="about-main-img-wrapper relative h-[90%] w-full overflow-hidden rounded-[24px] border border-slate-200/20 shadow-2xl transition-all duration-300 dark:border-slate-800/30"
                            >
                                <img
                                    src="/KKN_preview_rev_1.png"
                                    alt="Miftachul Umam"
                                    class="about-main-img h-full w-full object-cover transition-all duration-300"
                                />
                            </div>

                            <!-- Lapisan 2: Overlapping Badge Oranye -->
                            <div
                                class="about-badge shadow-karma absolute top-2 left-2 z-20 flex flex-col items-center justify-center rounded-[20px] border border-orange-400/20 bg-brand-orange px-5 py-6 text-center text-white transition-all duration-300"
                            >
                                <span
                                    class="text-2xl leading-none font-black tracking-tight"
                                    >2+</span
                                >
                                <span
                                    class="mt-1.5 text-[9px] font-bold tracking-wider text-orange-100 uppercase"
                                    >Years of</span
                                >
                                <span
                                    class="text-[9px] leading-none font-bold tracking-wider text-orange-100 uppercase"
                                    >Excellence</span
                                >
                            </div>

                            <!-- Lapisan 3: Overlapping Image Kecil -->
                            <div
                                class="about-secondary-img-wrapper absolute -right-2 bottom-2 z-25 transition-all duration-300 md:-right-6"
                            >
                                <img
                                    src="/about_ar_scan.png"
                                    alt="Augmented Reality WebAR Scan"
                                    class="h-28 w-28 rounded-[20px] border-[5px] border-white object-cover shadow-2xl md:h-36 md:w-36 dark:border-slate-900"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Deskripsi Profil JasaWeb -->
                    <div
                        class="reveal-element-right space-y-6 text-center font-sans lg:col-span-7 lg:text-left"
                    >
                        <!-- Section Tagline -->
                        <div
                            class="inline-flex items-center gap-1.5 rounded-full border border-orange-100 bg-orange-50 px-3 py-1 text-xs font-bold text-brand-orange dark:border-orange-900/30 dark:bg-orange-950/20 dark:text-orange-400"
                        >
                            <Sparkles class="h-3.5 w-3.5" />
                            TENTANG KAMI (ABOUT US)
                        </div>

                        <!-- Headline -->
                        <div class="space-y-1 pb-2">
                            <span
                                class="block text-xs font-black tracking-widest text-slate-900 uppercase dark:text-slate-200"
                            >
                                HI, PERKENALKAN SAYA
                            </span>
                            <h2
                                class="text-2xl leading-tight font-black tracking-tight text-brand-slate sm:text-3xl md:text-4xl dark:text-white"
                            >
                                <span class="text-brand-orange"
                                    >MIFTACHUL UMAM</span
                                >
                            </h2>
                        </div>

                        <!-- Description Paragraphs -->
                        <div
                            class="space-y-4 text-xs leading-relaxed font-medium text-slate-600 sm:text-sm dark:text-slate-300"
                        >
                            <p>
                                Seorang
                                <strong>Full Stack Developer</strong> yang
                                berfokus pada pengembangan website dan sistem
                                digital yang efisien, fungsional, dan aman.
                                Berbekal pengalaman di
                                <strong>PT Transindo Data Perkasa</strong>
                                sebagai programmer
                                <strong>SIMRS</strong>, saya terbiasa menangani
                                arsitektur data dengan kompleksitas tinggi.
                            </p>
                            <p>
                                Saya berpengalaman dalam membangun berbagai
                                solusi digital, seperti:
                            </p>
                            <div
                                class="my-2 space-y-2 border-l-2 border-brand-orange/30 py-0.5 pl-3"
                            >
                                <p>
                                    <strong
                                        class="text-brand-slate dark:text-white"
                                        >Sistem Manajemen:</strong
                                    >
                                    Logistik, Laboratorium, dan Pelaporan Toko
                                    Online.
                                </p>
                                <p>
                                    <strong
                                        class="text-brand-slate dark:text-white"
                                        >Kredibilitas:</strong
                                    >
                                    Website Company Profile dan Sekolah.
                                </p>
                                <p>
                                    <strong
                                        class="text-brand-slate dark:text-white"
                                        >Inovasi:</strong
                                    >
                                    Website berbasis
                                    <span class="font-bold text-brand-orange"
                                        >Augmented Reality (AR)</span
                                    >.
                                </p>
                            </div>
                            <p>
                                Punya kebutuhan digital lain? Mari diskusikan
                                ide hebat Anda bersama saya.
                            </p>
                        </div>

                        <div
                            class="grid grid-cols-1 gap-4 pt-2 text-left sm:grid-cols-2"
                        >
                            <div
                                class="flex items-start gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-3 dark:border-slate-800/80 dark:bg-slate-900"
                            >
                                <ShieldCheck
                                    class="mt-0.5 h-5 w-5 shrink-0 text-brand-orange"
                                />
                                <div>
                                    <h4
                                        class="text-xs font-bold text-slate-800 dark:text-white"
                                    >
                                        MoU Kontrak Fisik
                                    </h4>
                                </div>
                            </div>
                            <div
                                class="flex items-start gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-3 dark:border-slate-800/80 dark:bg-slate-900"
                            >
                                <GraduationCap
                                    class="mt-0.5 h-5 w-5 shrink-0 text-brand-orange"
                                />
                                <div>
                                    <h4
                                        class="text-xs font-bold text-slate-800 dark:text-white"
                                    >
                                        Training Staf Langsung
                                    </h4>
                                </div>
                            </div>
                            <div
                                class="flex items-start gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-3 dark:border-slate-800/80 dark:bg-slate-900"
                            >
                                <Zap
                                    class="mt-0.5 h-5 w-5 shrink-0 text-brand-orange"
                                />
                                <div>
                                    <h4
                                        class="text-xs font-bold text-slate-800 dark:text-white"
                                    >
                                        Komunikasi Cepat & Responsif
                                    </h4>
                                </div>
                            </div>
                            <div
                                class="flex items-start gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-3 dark:border-slate-800/80 dark:bg-slate-900"
                            >
                                <CheckCircle2
                                    class="mt-0.5 h-5 w-5 shrink-0 text-brand-orange"
                                />
                                <div>
                                    <h4
                                        class="text-xs font-bold text-slate-800 dark:text-white"
                                    >
                                        Bayar Bertahap (Milestones)
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex flex-col items-center justify-center gap-4 pt-4 sm:flex-row lg:justify-start"
                        >
                            <a
                                :href="directWaUrl"
                                target="_blank"
                                class="shadow-karma inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-brand-orange px-8 py-4.5 text-xs font-bold tracking-wider text-white uppercase transition hover:bg-brand-orange-dark sm:w-auto"
                            >
                                <PhoneCall class="h-4 w-4" />
                                Hubungi Tim Developer Kami
                            </a>
                            <a
                                href="#projek"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-slate-100 px-8 py-4.5 font-sans text-xs font-bold text-slate-700 transition hover:bg-slate-200 sm:w-auto dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                            >
                                Lihat Projek Kami
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Dynamic Demo Section (AR Simulator) [TEMPORARILY HIDDEN] -->
            <!--
            <section id="demo" class="py-16 md:py-24 bg-slate-100/50 dark:bg-slate-900/30 border-y border-slate-200/50 dark:border-slate-800/30">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="text-center max-w-3xl mx-auto space-y-3 mb-16 reveal-element">
                        <span class="text-xs font-bold text-brand-orange dark:text-orange-400 tracking-widest uppercase font-sans">INTERACTIVE DEMO PREVIEW</span>
                        <h2 class="text-3xl font-black tracking-tight text-brand-slate dark:text-white">
                            Coba Fitur Web AR Mebel Secara Instan!
                        </h2>
                        <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400">
                            Ganti warna kain jok &amp; finishing jati pada sofa di bawah. Rasakan sendiri betapa interaktifnya teknologi masa depan katalog Anda.
                        </p>
                    </div>

                    <div class="reveal-element-scale">
                        <ARSimulator />
                    </div>
                </div>
            </section>
            -->

            <!-- Redesigned Portfolio Projects Section (Replaces Case Studies - 3 columns, 2 rows) -->
            <section
                id="projek"
                class="relative overflow-hidden bg-white py-20 md:py-28 dark:bg-slate-950"
            >
                <div
                    class="bg-dot-grid pointer-events-none absolute inset-0 opacity-20"
                ></div>

                <div class="relative z-10 mx-auto max-w-7xl px-6">
                    <div
                        class="reveal-element mx-auto mb-16 max-w-3xl space-y-3 text-center font-sans"
                    >
                        <!-- Badge -->
                        <div
                            class="inline-flex items-center gap-1.5 rounded-full border border-orange-100 bg-orange-50 px-3 py-1 text-xs font-bold text-brand-orange dark:border-orange-900/30 dark:bg-orange-950/20 dark:text-orange-400"
                        >
                            <Award class="h-3.5 w-3.5" />
                            PORTFOLIO SHOWCASE
                        </div>
                        <h2
                            class="text-3xl font-black tracking-tight text-brand-slate dark:text-white"
                        >
                            Portofolio Solusi Digital
                        </h2>
                        <p
                            class="text-xs text-slate-500 md:text-sm dark:text-slate-400"
                        >
                            Kumpulan proyek website dan sistem digital kustom
                            yang dirancang dengan standar kualitas dan
                            fungsionalitas terbaik.
                        </p>
                    </div>

                    <!-- Projects Grid (3 Columns!) -->
                    <div
                        class="grid grid-cols-1 gap-6 font-sans md:grid-cols-3 lg:gap-8"
                    >
                        <div
                            v-for="(project, idx) in projects"
                            :key="project.id"
                            @click="openProject(project)"
                            class="group flex cursor-pointer flex-col justify-between overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-xl dark:border-slate-800/80 dark:bg-slate-900"
                            :class="[
                                'reveal-element',
                                'delay-' + (idx % 3) * 100,
                            ]"
                        >
                            <!-- Card Image -->
                            <div
                                class="relative aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-slate-950"
                            >
                                <img
                                    :src="project.image"
                                    :alt="project.title"
                                    class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                />

                                <!-- Glassmorphic Image Hover Overlay -->
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-slate-950/30 opacity-0 backdrop-blur-[2px] transition-all duration-300 group-hover:opacity-100"
                                >
                                    <div
                                        class="flex translate-y-3 transform items-center gap-1.5 rounded-full bg-white/95 px-5 py-2.5 text-xs font-bold text-slate-900 shadow-lg transition-transform duration-300 group-hover:translate-y-0 dark:bg-slate-900/95 dark:text-white"
                                    >
                                        <Eye
                                            class="h-4 w-4 text-brand-orange"
                                        />
                                        <span>Lihat Detail Projek</span>
                                    </div>
                                </div>

                                <!-- Project Category Badge (Conditional) -->
                                <span
                                    v-if="project.category"
                                    class="absolute top-3 left-3 z-10 rounded-full bg-brand-orange/90 px-3 py-1 text-[9px] font-black tracking-wider text-white uppercase shadow-sm backdrop-blur-sm"
                                >
                                    {{ project.category }}
                                </span>
                            </div>

                            <!-- Card Body -->
                            <div class="flex-1 space-y-2.5 p-6">
                                <!-- Client badge (Conditional) -->
                                <div v-if="project.client" class="flex">
                                    <span
                                        class="border-slate-150/40 inline-flex items-center gap-1 rounded-md border bg-slate-50 px-2 py-0.5 text-[9px] font-bold tracking-wide text-slate-500 dark:border-slate-800 dark:bg-slate-900/50 dark:text-slate-400"
                                    >
                                        Client: {{ project.client }}
                                    </span>
                                </div>

                                <h3
                                    class="text-base leading-snug font-bold text-slate-800 transition-colors group-hover:text-brand-orange dark:text-white"
                                >
                                    {{ project.title }}
                                </h3>

                                <p
                                    v-if="project.description"
                                    class="line-clamp-3 text-[11px] leading-relaxed font-medium text-slate-500 dark:text-slate-400"
                                >
                                    {{ project.description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- More Projects Call-to-Action (WhatsApp Redirection) -->
                    <div class="reveal-element mt-12 text-center font-sans">
                        <a
                            :href="
                                getWaLink(
                                    'Halo JasaWeb Cluwak, saya ingin melihat portfolio projek sistem/website selengkapnya yang pernah dikerjakan...',
                                )
                            "
                            target="_blank"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-2xl border border-slate-200 bg-white px-8 py-4 font-sans text-xs font-bold text-slate-700 shadow-sm transition hover:scale-102 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                        >
                            <span>Lihat Lebih Banyak Projek Portofolio</span>
                            <Plus
                                class="h-4 w-4 shrink-0 stroke-[3] text-brand-orange"
                            />
                        </a>
                    </div>
                </div>

                <!-- Immersion Full-Screen Details Modal -->
                <Transition
                    enter-active-class="transition duration-300 ease-out"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="transition duration-200 ease-in"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-if="selectedProject"
                        class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-950/75 p-4 backdrop-blur-md md:p-6"
                        @click.self="closeProject"
                    >
                        <div
                            class="relative flex max-h-[90vh] w-full max-w-4xl scale-100 transform flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white font-sans shadow-2xl transition-transform duration-300 dark:border-slate-800 dark:bg-slate-900"
                        >
                            <!-- Header / Absolute Close -->
                            <button
                                @click="closeProject"
                                class="absolute top-4 right-4 z-20 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-slate-900/5 text-slate-700 transition hover:bg-slate-900/10 dark:bg-white/5 dark:text-slate-300 dark:hover:bg-white/10"
                            >
                                <X class="h-5 w-5" />
                            </button>

                            <div class="flex-1 overflow-y-auto p-6 md:p-8">
                                <div
                                    class="grid grid-cols-1 gap-8 lg:grid-cols-12"
                                >
                                    <!-- Left: Project Visuals -->
                                    <div
                                        class="flex flex-col justify-center lg:col-span-6"
                                    >
                                        <div
                                            class="overflow-hidden rounded-2xl border border-slate-200/50 bg-slate-100 shadow-inner dark:border-slate-800 dark:bg-slate-950"
                                        >
                                            <img
                                                :src="selectedProject.image"
                                                :alt="selectedProject.title"
                                                class="h-auto max-h-[380px] w-full object-cover"
                                            />
                                        </div>

                                        <!-- Tech Details inside Modal -->
                                        <div
                                            v-if="
                                                selectedProject.tech &&
                                                selectedProject.tech.length
                                            "
                                            class="mt-5 space-y-2"
                                        >
                                            <span
                                                class="block text-[10px] font-bold tracking-widest text-slate-400 uppercase"
                                                >TEKNOLOGI YANG DIGUNAKAN</span
                                            >
                                            <div class="flex flex-wrap gap-2">
                                                <span
                                                    v-for="tech in selectedProject.tech"
                                                    :key="tech"
                                                    class="rounded-xl border border-orange-100/50 bg-orange-50 px-3 py-1 text-xs font-bold text-brand-orange dark:border-orange-900/20 dark:bg-orange-950/20 dark:text-orange-400"
                                                >
                                                    {{ tech }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right: Project Description & Client Details -->
                                    <div
                                        class="flex flex-col justify-between space-y-5 lg:col-span-6"
                                    >
                                        <div class="space-y-4">
                                            <div
                                                v-if="selectedProject.category"
                                                class="dark:text-slate-355 inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700 dark:bg-slate-800"
                                            >
                                                <Layers
                                                    class="h-3.5 w-3.5 text-brand-orange"
                                                />
                                                {{ selectedProject.category }}
                                            </div>

                                            <h2
                                                class="text-2xl font-black text-slate-800 dark:text-white"
                                            >
                                                {{ selectedProject.title }}
                                            </h2>

                                            <div
                                                v-if="
                                                    selectedProject.client ||
                                                    selectedProject.description
                                                "
                                                class="dark:text-slate-350 space-y-3 text-xs leading-relaxed font-medium text-slate-600"
                                            >
                                                <p
                                                    v-if="
                                                        selectedProject.client
                                                    "
                                                    class="font-sans font-bold text-brand-orange"
                                                >
                                                    Klien:
                                                    {{ selectedProject.client }}
                                                </p>
                                                <p
                                                    v-if="
                                                        selectedProject.description
                                                    "
                                                >
                                                    {{
                                                        selectedProject.description
                                                    }}
                                                </p>
                                            </div>

                                            <!-- Impact Highlight Box -->
                                            <div
                                                v-if="selectedProject.impact"
                                                class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 text-xs dark:border-emerald-900/20 dark:bg-emerald-950/10"
                                            >
                                                <p
                                                    class="mb-1 flex items-center gap-1.5 font-sans text-[11px] font-bold text-emerald-800 dark:text-emerald-400"
                                                >
                                                    <ShieldCheck
                                                        class="h-4.5 w-4.5 text-emerald-600 dark:text-emerald-500"
                                                    />
                                                    Dampak / Solusi Nyata
                                                </p>
                                                <p
                                                    class="leading-normal text-slate-600 dark:text-slate-400"
                                                >
                                                    {{ selectedProject.impact }}
                                                </p>
                                            </div>

                                            <!-- Project Links (GitHub & Live Demo) -->
                                            <div
                                                v-if="
                                                    selectedProject.github_url ||
                                                    selectedProject.demo_url
                                                "
                                                class="space-y-2.5 rounded-2xl border border-slate-100 bg-slate-50/50 p-4 text-xs dark:border-slate-800/40 dark:bg-slate-900/20"
                                            >
                                                <p
                                                    class="flex items-center gap-1.5 font-sans text-[11px] font-bold text-slate-700 dark:text-slate-300"
                                                >
                                                    <Layers
                                                        class="h-4 w-4 text-brand-orange"
                                                    />
                                                    Akses & Tautan Projek
                                                </p>
                                                <div
                                                    class="flex flex-wrap gap-2.5 pt-0.5"
                                                >
                                                    <a
                                                        v-if="
                                                            selectedProject.github_url
                                                        "
                                                        :href="
                                                            selectedProject.github_url
                                                        "
                                                        target="_blank"
                                                        class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-[11px] font-bold text-slate-700 shadow-sm transition hover:scale-102 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                                                    >
                                                        <Github
                                                            class="h-4 w-4 text-slate-800 dark:text-slate-100"
                                                        />
                                                        <span
                                                            >Repository
                                                            GitHub</span
                                                        >
                                                        <ExternalLink
                                                            class="h-3 w-3 text-slate-400"
                                                        />
                                                    </a>
                                                    <a
                                                        v-if="
                                                            selectedProject.demo_url
                                                        "
                                                        :href="
                                                            selectedProject.demo_url
                                                        "
                                                        target="_blank"
                                                        class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-[11px] font-bold text-slate-700 shadow-sm transition hover:scale-102 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                                                    >
                                                        <ExternalLink
                                                            class="h-4 w-4 text-brand-orange"
                                                        />
                                                        <span
                                                            >Lihat Website
                                                            Demo</span
                                                        >
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- WhatsApp CTA customized to the project -->
                                        <div
                                            class="border-t border-slate-100 pt-4 dark:border-slate-800"
                                        >
                                            <a
                                                :href="
                                                    getWaLink(
                                                        selectedProject.waMessage,
                                                    )
                                                "
                                                target="_blank"
                                                class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-2xl bg-brand-orange px-6 py-3.5 font-sans text-xs font-black tracking-wider text-white uppercase shadow-md transition duration-300 hover:bg-brand-orange-dark"
                                            >
                                                <PhoneCall class="h-4 w-4" />
                                                Tanya Solusi Projek Seperti Ini
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </Transition>
            </section>

            <!-- Redesigned Pricing Section (Exactly Aligned with the Screenshots) -->
            <section
                id="pricing"
                class="relative overflow-hidden bg-slate-50 py-20 font-sans md:py-28 dark:bg-slate-900/10"
            >
                <!-- Dot Grid Background -->
                <div
                    class="bg-dot-grid pointer-events-none absolute inset-0 opacity-20"
                ></div>

                <!-- Desktop Orange Stripe background (Exactly matches the screenshot) -->
                <div
                    class="absolute top-[38%] right-0 left-0 -z-10 hidden h-[200px] bg-brand-orange lg:block"
                ></div>

                <div class="relative z-10 mx-auto max-w-7xl px-6">
                    <div
                        class="reveal-element mx-auto mb-16 max-w-3xl space-y-3 text-center"
                    >
                        <h2
                            class="font-sans text-3xl leading-tight font-black tracking-tight text-brand-slate sm:text-4xl dark:text-white"
                        >
                            Pilih Paket yang Sesuai untuk Bisnis Anda
                        </h2>
                        <p
                            class="font-sans text-xs font-bold text-slate-500 md:text-sm dark:text-slate-400"
                        >
                            Layanan Web Profesional JasaWeb, Harga Transparan
                        </p>
                    </div>

                    <!-- Pricing Cards Grid -->
                    <div
                        class="relative mx-auto grid max-w-6xl grid-cols-1 items-stretch gap-8 md:grid-cols-3"
                    >
                        <div
                            v-for="(pkg, idx) in pricingPackages"
                            :key="pkg.name"
                            class="shadow-karma-soft relative flex flex-col justify-between overflow-hidden rounded-3xl border border-slate-100 bg-white transition-all duration-300 hover:-translate-y-2 dark:border-slate-800/80 dark:bg-slate-900"
                            :class="[
                                pkg.popular
                                    ? 'z-10 scale-103 border-2 border-brand-orange shadow-lg shadow-orange-500/5'
                                    : 'border-slate-200/60 dark:border-slate-800/80',
                                'reveal-element',
                                'delay-' + idx * 100,
                            ]"
                        >
                            <!-- Popular Tag Badge -->
                            <div
                                v-if="pkg.popular"
                                class="absolute top-4 right-4 z-20 rounded-full bg-brand-orange px-3.5 py-1 text-[9px] font-black tracking-widest text-white uppercase shadow-sm"
                            >
                                Populer
                            </div>

                            <!-- Simplified Minimal Header -->
                            <div class="px-6 pt-8 pb-4 text-center">
                                <h3
                                    class="text-lg font-black text-slate-800 dark:text-white"
                                >
                                    {{ pkg.name }}
                                </h3>
                                <p
                                    v-if="pkg.tagline"
                                    class="mt-2 text-[10px] leading-relaxed font-bold tracking-wider text-slate-400 uppercase dark:text-slate-500"
                                >
                                    {{ pkg.tagline }}
                                </p>
                            </div>

                            <!-- Card Body -->
                            <div
                                class="flex flex-1 flex-col justify-between space-y-6 bg-white p-6 pt-2 md:p-8 md:pt-2 dark:bg-slate-900"
                            >
                                <div class="space-y-5">
                                    <!-- Package Price with slashed price discount -->
                                    <div
                                        class="flex flex-col items-center justify-center py-2 text-center"
                                    >
                                        <span
                                            v-if="pkg.slashedPrice"
                                            class="mb-1 text-xs font-bold text-rose-500 line-through opacity-80"
                                        >
                                            {{ pkg.slashedPrice }}
                                        </span>

                                        <div
                                            class="flex items-baseline justify-center"
                                        >
                                            <span
                                                class="text-2xl font-black text-slate-800 md:text-3xl dark:text-white"
                                                :class="{
                                                    'text-brand-orange':
                                                        pkg.popular,
                                                }"
                                                >{{ pkg.price }}</span
                                            >
                                            <span
                                                class="text-slate-450 ml-1 text-[10px] font-bold dark:text-slate-400"
                                                v-if="
                                                    pkg.price !== 'Harga Kustom'
                                                "
                                                >/ Sekali</span
                                            >
                                        </div>
                                    </div>

                                    <!-- Features List -->
                                    <ul
                                        class="dark:text-slate-350 space-y-3.5 pl-2 text-xs leading-relaxed font-medium text-slate-500"
                                    >
                                        <li
                                            v-for="feature in pkg.features"
                                            :key="feature"
                                            class="flex items-start gap-2.5"
                                        >
                                            <span
                                                class="mt-0.5 shrink-0 font-black tracking-tighter text-brand-orange"
                                                >••</span
                                            >
                                            <span>{{ feature }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- CTA Buttons inside Cards -->
                                <div class="pt-6">
                                    <a
                                        :href="getWaLink(pkg.waText)"
                                        target="_blank"
                                        class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-2xl px-6 py-3.5 font-sans text-xs font-black tracking-wider uppercase shadow-sm transition duration-300 hover:scale-102"
                                        :class="
                                            pkg.popular
                                                ? 'bg-brand-orange text-white shadow-orange-500/20 hover:bg-brand-orange-dark'
                                                : 'border border-brand-orange bg-white text-brand-orange hover:bg-slate-50 dark:bg-slate-900 dark:hover:bg-slate-800'
                                        "
                                    >
                                        Pilih Paket
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Guarantees Row -->
                    <div
                        class="text-slate-650 reveal-element mx-auto grid max-w-4xl grid-cols-1 gap-6 pt-14 font-sans sm:grid-cols-3 dark:text-slate-300"
                    >
                        <div
                            class="flex items-center justify-center gap-3 rounded-2xl border border-slate-200/40 bg-white/40 p-3.5 shadow-sm dark:border-slate-800/40 dark:bg-slate-900/30"
                        >
                            <Lock class="h-5 w-5 shrink-0 text-brand-orange" />
                            <span class="font-sans text-xs font-bold"
                                >Pembayaran Bertahap (Aman)</span
                            >
                        </div>
                        <div
                            class="flex items-center justify-center gap-3 rounded-2xl border border-slate-200/40 bg-white/40 p-3.5 shadow-sm dark:border-slate-800/40 dark:bg-slate-900/30"
                        >
                            <TrendingUp
                                class="h-5 w-5 shrink-0 text-brand-orange"
                            />
                            <span class="font-sans text-xs font-bold"
                                >Akses Cepat (Backend Ringan)</span
                            >
                        </div>
                        <div
                            class="flex items-center justify-center gap-3 rounded-2xl border border-slate-200/40 bg-white/40 p-3.5 shadow-sm dark:border-slate-800/40 dark:bg-slate-900/30"
                        >
                            <CheckCircle2
                                class="h-5 w-5 shrink-0 text-brand-orange"
                            />
                            <span class="font-sans text-xs font-bold"
                                >Domain &amp; Hosting Include</span
                            >
                        </div>
                    </div>

                    <!-- Consultation Button -->
                    <div class="reveal-element mt-10 text-center font-sans">
                        <a
                            :href="
                                getWaLink(
                                    'Halo JasaWeb Cluwak, saya butuh saran mengenai paket website yang cocok untuk bisnis saya...',
                                )
                            "
                            target="_blank"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-2xl border border-slate-200 bg-white px-8 py-4 font-sans text-xs font-bold text-slate-700 shadow-sm transition hover:scale-102 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                        >
                            <span>Butuh Saran? Konsultasi WA Sekarang!</span>
                            <ArrowRight
                                class="h-4 w-4 shrink-0 text-brand-orange"
                            />
                        </a>
                    </div>
                </div>
            </section>

            <!-- Keunggulan Section (Kenapa Developer Lokal Cluwak) -->
            <section
                id="kenapa-kami"
                class="relative overflow-hidden bg-brand-slate py-20 text-white md:py-28"
            >
                <!-- Decorative Orange glow inside dark section -->
                <div
                    class="absolute top-1/2 left-1/2 h-[350px] w-[350px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-orange/20 font-sans opacity-50 blur-3xl"
                ></div>

                <div class="relative z-10 mx-auto max-w-7xl px-6">
                    <div
                        class="reveal-element mx-auto mb-16 max-w-3xl space-y-3 text-center"
                    >
                        <span
                            class="font-sans text-xs font-bold tracking-widest text-brand-orange uppercase"
                            >INTEGRITAS LOKAL</span
                        >
                        <h2
                            class="font-sans text-3xl leading-tight font-black tracking-tight"
                        >
                            Kenapa Bekerja Sama dengan Developer Lokal (Cluwak)?
                        </h2>
                        <p class="font-sans text-xs text-slate-400 md:text-sm">
                            Saya berikan solusi digital terpercaya dengan
                            kedekatan jarak, transparansi harga, dan
                            pendampingan tatap muka langsung.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-1 gap-8 font-sans md:grid-cols-4"
                    >
                        <!-- Card 1 -->
                        <div
                            class="flex flex-col gap-4 rounded-2xl border border-slate-800 bg-slate-900/60 p-6"
                            :class="['reveal-element', 'delay-0']"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-orange-900/30 bg-orange-950/40 text-brand-orange"
                                >
                                    <MapPin class="h-5 w-5" />
                                </div>
                                <h4
                                    class="font-sans text-sm font-bold text-white"
                                >
                                    Jarak Dekat &amp; MoU Fisik
                                </h4>
                            </div>
                            <p
                                class="font-sans text-xs leading-relaxed text-slate-400"
                            >
                                Saya berdomisili di Cluwak dan siap berkunjung
                                langsung ke tempat Anda di area Pati, Jepara,
                                atau Kudus untuk diskusi tatap muka dan tanda
                                tangan MoU resmi.
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div
                            class="flex flex-col gap-4 rounded-2xl border border-slate-800 bg-slate-900/60 p-6"
                            :class="['reveal-element', 'delay-100']"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-orange-900/30 bg-orange-950/40 text-brand-orange"
                                >
                                    <Zap class="h-5 w-5" />
                                </div>
                                <h4
                                    class="font-sans text-sm font-bold text-white"
                                >
                                    Loading Kilat di Pelosok
                                </h4>
                            </div>
                            <p
                                class="font-sans text-xs leading-relaxed text-slate-400"
                            >
                                Seluruh website dan sistem kustom dioptimalkan
                                secara ekstrem agar loading cepat, responsif,
                                dan lancar diakses bahkan di pelosok dengan
                                jaringan seluler minim.
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div
                            class="flex flex-col gap-4 rounded-2xl border border-slate-800 bg-slate-900/60 p-6"
                            :class="['reveal-element', 'delay-200']"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-orange-900/30 bg-orange-950/40 text-brand-orange"
                                >
                                    <GraduationCap class="h-5 w-5" />
                                </div>
                                <h4
                                    class="font-sans text-sm font-bold text-white"
                                >
                                    Training &amp; Support Fisik
                                </h4>
                            </div>
                            <p
                                class="font-sans text-xs leading-relaxed text-slate-400"
                            >
                                Saya siap datang langsung memberikan
                                pendampingan dan training pengelolaan website,
                                admin panel, atau sistem internal sampai
                                Anda/tim mahir menggunakannya.
                            </p>
                        </div>

                        <!-- Card 4 -->
                        <div
                            class="flex flex-col gap-4 rounded-2xl border border-slate-800 bg-slate-900/60 p-6"
                            :class="['reveal-element', 'delay-300']"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-orange-900/30 bg-orange-950/40 text-brand-orange"
                                >
                                    <ShieldCheck class="h-5 w-5" />
                                </div>
                                <h4
                                    class="font-sans text-sm font-bold text-white"
                                >
                                    Bayar Bertahap Aman
                                </h4>
                            </div>
                            <p
                                class="font-sans text-xs leading-relaxed text-slate-400"
                            >
                                Keamanan transaksi terjamin dengan sistem termin
                                (milestones). Anda cukup membayar bertahap
                                setelah melihat hasil progres pengerjaan nyata
                                di setiap tahapan.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Interactive Contact & Locations Section -->
            <section
                id="kontak"
                class="bg-slate-50 py-20 md:py-28 dark:bg-slate-900/10"
            >
                <div class="mx-auto max-w-7xl px-6">
                    <div
                        class="grid grid-cols-1 items-stretch gap-12 lg:grid-cols-12"
                    >
                        <!-- Left Column: Google Maps & Workshop details -->
                        <div
                            class="reveal-element-left flex flex-col justify-between space-y-6 lg:col-span-7"
                        >
                            <div class="space-y-4">
                                <div
                                    class="inline-flex items-center gap-1.5 rounded-full border border-orange-100 bg-orange-50 px-3 py-1 text-xs font-bold text-brand-orange dark:border-orange-900/30 dark:bg-orange-950/20 dark:text-orange-400"
                                >
                                    <Globe class="h-3.5 w-3.5" />
                                    DOMISILI &amp; WILAYAH PERTEMUAN
                                </div>
                                <h3
                                    class="text-2xl leading-tight font-black tracking-tight text-brand-slate dark:text-white"
                                >
                                    Siap Diskusi &amp; Tatap Muka
                                    <span class="text-brand-orange"
                                        >Di Lokasi Pilihan Anda</span
                                    >
                                </h3>
                            </div>

                            <!-- Map Iframe Wrapper -->
                            <div
                                class="grow overflow-hidden rounded-3xl border border-slate-100 bg-white p-3 shadow-xl dark:border-slate-800 dark:bg-slate-900"
                            >
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d990.8719875957813!2d110.98354605915599!3d-6.534849303536814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e712f00234f71a5%3A0xf3524bf277ceb1cb!2sJasa%20Web%20Pati%2C%20Jepara!5e0!3m2!1sid!2sid!4v1716867389421!5m2!1sid!2sid"
                                    class="block h-[280px] w-full rounded-2xl border-0 md:h-[320px]"
                                    allowfullscreen="true"
                                    loading="lazy"
                                ></iframe>
                            </div>

                            <!-- Details Card grid -->
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div
                                    class="border-slate-150/40 dark:border-slate-850 flex items-start gap-3 rounded-2xl border bg-white p-4 shadow-sm dark:bg-slate-900"
                                >
                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-brand-orange dark:bg-orange-950/20"
                                    >
                                        <MapPin class="h-4 w-4" />
                                    </div>
                                    <div class="space-y-0.5">
                                        <span
                                            class="block text-[10px] font-bold tracking-wider text-slate-400 uppercase"
                                            >DOMISILI UTAMA</span
                                        >
                                        <p
                                            class="text-[11px] leading-normal font-black text-slate-700 dark:text-slate-200"
                                        >
                                            Jln. Raya Tayu - Jepara KM. 7, Kec.
                                            Cluwak, Kabupaten Pati, Jawa Tengah,
                                            Indonesia
                                        </p>
                                    </div>
                                </div>

                                <div
                                    class="border-slate-150/40 dark:border-slate-850 flex items-start gap-3 rounded-2xl border bg-white p-4 shadow-sm dark:bg-slate-900"
                                >
                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-brand-orange dark:bg-orange-950/20"
                                    >
                                        <Clock class="h-4 w-4" />
                                    </div>
                                    <div class="space-y-0.5">
                                        <span
                                            class="block text-[10px] font-bold tracking-wider text-slate-400 uppercase"
                                            >JAM OPERASIONAL</span
                                        >
                                        <p
                                            class="text-[11px] leading-normal font-black text-slate-700 dark:text-slate-200"
                                        >
                                            Setiap Hari: 08:00 - 20:00 WIB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Interactive Consultation WhatsApp Form -->
                        <div
                            class="reveal-element-right flex flex-col justify-center lg:col-span-5"
                        >
                            <div
                                class="space-y-6 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xl md:p-8 dark:border-slate-800 dark:bg-slate-900"
                            >
                                <div class="space-y-2">
                                    <h4
                                        class="text-xl leading-tight font-black tracking-tight text-slate-800 dark:text-white"
                                    >
                                        Konsultasi Proyek
                                        <span class="text-brand-orange"
                                            >Gratis</span
                                        >
                                    </h4>
                                    <p
                                        class="text-slate-450 text-xs leading-relaxed font-medium"
                                    >
                                        Rencanakan pembuatan website profil
                                        bisnis, landing page premium, toko
                                        online, atau sistem aplikasi kustom Anda
                                        sekarang. Kami akan langsung mengarahkan
                                        Anda ke ruang WhatsApp kami.
                                    </p>
                                </div>

                                <!-- Form Inputs -->
                                <div class="space-y-4 font-sans text-xs">
                                    <!-- Name Field -->
                                    <div class="space-y-1.5">
                                        <label
                                            class="dark:text-slate-350 block font-black text-slate-700"
                                            >NAMA LENGKAP ANDA *</label
                                        >
                                        <input
                                            type="text"
                                            v-model="contactForm.name"
                                            placeholder="Masukkan nama panggilan atau nama bisnis Anda"
                                            class="dark:border-slate-855 w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-xs font-semibold transition outline-none focus:border-brand-orange focus:bg-white focus:ring-1 focus:ring-brand-orange dark:bg-slate-950 dark:text-white"
                                        />
                                    </div>

                                    <!-- Service Field -->
                                    <div class="space-y-1.5">
                                        <label
                                            class="dark:text-slate-350 block font-black text-slate-700"
                                            >LAYANAN YANG DIBUTUHKAN</label
                                        >
                                        <div class="relative">
                                            <select
                                                v-model="contactForm.service"
                                                class="dark:border-slate-855 w-full appearance-none rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-xs font-semibold transition outline-none focus:border-brand-orange focus:bg-white focus:ring-1 focus:ring-brand-orange dark:bg-slate-950 dark:text-white"
                                            >
                                                <option
                                                    value="Website Profil Bisnis (Company Profile)"
                                                >
                                                    Website Profil Bisnis
                                                    (Company Profile)
                                                </option>
                                                <option
                                                    value="Sistem Informasi Kasir & Stok (ERP)"
                                                >
                                                    Sistem Informasi Kasir &amp;
                                                    Stok (ERP)
                                                </option>
                                                <option
                                                    value="Toko Online / E-Commerce Premium"
                                                >
                                                    Toko Online / E-Commerce
                                                    Premium
                                                </option>
                                                <option
                                                    value="Website Katalog Visual 3D & AR"
                                                >
                                                    Website Katalog Visual 3D
                                                    &amp; AR
                                                </option>
                                                <option
                                                    value="Custom Development / Aplikasi Custom"
                                                >
                                                    Custom Development /
                                                    Aplikasi Custom
                                                </option>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400"
                                            >
                                                <ChevronDown class="h-4 w-4" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Message Field -->
                                    <div class="space-y-1.5">
                                        <label
                                            class="dark:text-slate-350 block font-black text-slate-700"
                                            >CERITAKAN SINGKAT KEBUTUHAN ANDA
                                            (OPSIONAL)</label
                                        >
                                        <textarea
                                            v-model="contactForm.message"
                                            rows="4"
                                            placeholder="Contoh: Halo JasaWeb, saya ingin berkonsultasi mengenai pembuatan website landing page profil bisnis perusahaan saya atau pembuatan sistem kasir kustom..."
                                            class="dark:border-slate-855 w-full resize-none rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-xs font-semibold transition outline-none focus:border-brand-orange focus:bg-white focus:ring-1 focus:ring-brand-orange dark:bg-slate-950 dark:text-white"
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <button
                                    @click="submitContactToWa"
                                    :disabled="!contactForm.name.trim()"
                                    class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-brand-orange py-4 font-sans text-xs font-black tracking-widest text-white uppercase shadow-lg shadow-orange-500/10 transition duration-300 hover:scale-102 hover:bg-brand-orange-dark disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    <Send class="h-4.5 w-4.5" />
                                    <span>Hubungi Kami via WhatsApp</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Final CTA Banner -->
            <section
                class="relative overflow-hidden bg-gradient-to-tr from-brand-orange to-amber-500 py-20 text-white md:py-24"
            >
                <!-- Dot Grid Accent inside CTA -->
                <div
                    class="bg-dot-grid pointer-events-none absolute inset-0 opacity-15"
                ></div>

                <div
                    class="reveal-element relative z-10 mx-auto max-w-5xl space-y-6 px-6 text-center font-sans"
                >
                    <h2
                        class="font-sans text-2xl leading-tight font-black tracking-tight md:text-4xl"
                    >
                        Siap Mengubah Bisnis Anda Menjadi Lebih Rapi &amp;
                        Dipercaya Klien?
                    </h2>
                    <p
                        class="mx-auto max-w-2xl font-sans text-xs leading-relaxed font-medium text-orange-50 md:text-sm"
                    >
                        Jangan biarkan calon pelanggan ragu dengan
                        profesionalisme bisnis Anda, dan cegah kebocoran sistem
                        operasional mulai sekarang. Mari wujudkan sistem impian
                        Anda bersama pengembang terdekat yang siap diandalkan
                        tatap muka.
                    </p>
                    <div
                        class="flex flex-col items-center justify-center gap-4 pt-4 sm:flex-row"
                    >
                        <a
                            :href="directWaUrl"
                            target="_blank"
                            class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-2xl bg-white px-8 py-4 font-sans text-sm font-black text-brand-orange-dark shadow-xl transition duration-300 hover:scale-102 hover:bg-slate-50 sm:w-auto"
                        >
                            <PhoneCall
                                class="h-4.5 w-4.5 animate-pulse text-brand-orange"
                            />
                            Konsultasikan Proyek Anda Sekarang (Gratis)
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Wave Accent transition before footer (Connected Orange -> Deep Slate Wave Effect) -->
        <div
            class="relative w-full overflow-hidden bg-gradient-to-tr from-brand-orange to-amber-500 leading-[0]"
        >
            <svg
                class="relative block h-[60px] max-h-[150px] min-h-[60px] w-[200%] md:h-[120px] md:w-full"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28"
                preserveAspectRatio="none"
                shape-rendering="auto"
            >
                <defs>
                    <path
                        id="gentle-wave"
                        d="M-160 44c30 0 58-18 88-18s58 18 88 18 58-18 88-18 58 18 88 18v44h-352z"
                    />
                </defs>
                <g class="wave-layer font-sans">
                    <use
                        xlink:href="#gentle-wave"
                        x="48"
                        y="0"
                        class="wave-layer-1 fill-white/10 dark:fill-slate-950/10"
                    />
                    <use
                        xlink:href="#gentle-wave"
                        x="48"
                        y="3"
                        class="wave-layer-2 fill-white/20 dark:fill-slate-950/20"
                    />
                    <use
                        xlink:href="#gentle-wave"
                        x="48"
                        y="5"
                        class="wave-layer-3 fill-white/35 dark:fill-slate-950/35"
                    />
                    <use
                        xlink:href="#gentle-wave"
                        x="48"
                        y="7"
                        class="wave-layer-4 fill-brand-slate dark:fill-slate-950"
                    />
                </g>
            </svg>
        </div>

        <!-- Footer (High-contrast slate-300 font colors for perfect visibility) -->
        <footer
            class="bg-brand-slate py-12 font-sans text-slate-300 dark:bg-slate-950"
        >
            <div
                class="mx-auto grid max-w-7xl grid-cols-1 items-start gap-8 px-6 md:grid-cols-12"
            >
                <!-- Brand Profile -->
                <div class="space-y-4 md:col-span-5">
                    <div class="flex items-center gap-2.5">
                        <div class="relative flex h-9 w-9 shrink-0 items-center justify-center">
                            <div
                                class="absolute inset-0 rounded-2xl bg-brand-orange/10 opacity-80 blur-[2px] transition duration-300 group-hover:scale-110"
                            ></div>
                            <div
                                class="relative flex h-7.5 w-7.5 items-center justify-center rounded-lg border border-orange-200/60 bg-white/70 text-brand-orange shadow-sm transition duration-300 dark:border-orange-500/20 dark:bg-slate-900/60"
                            >
                                <svg
                                    class="h-3.5 w-3.5"
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
                            class="font-sans text-lg font-extrabold text-white"
                        >
                            Jasa<span class="font-sans text-brand-orange"
                                >Web</span
                            ><span class="text-brand-orange font-black">.</span>
                        </span>
                    </div>
                    <p
                        class="text-xs leading-relaxed text-slate-300 dark:text-slate-400"
                    >
                        Mitra pengembang website &amp; sistem kustom terpercaya
                        untuk profil bisnis, e-commerce, instansi, toko ritel,
                        katalog visual, serta UMKM komersial di wilayah
                        Kabupaten Pati, Jepara, dan sekitarnya.
                    </p>
                </div>

                <!-- Geographics Location -->
                <div class="space-y-3 md:col-span-4">
                    <h5
                        class="font-sans text-xs font-bold tracking-widest text-white uppercase"
                    >
                        DOMISILI &amp; AREA LAYANAN
                    </h5>
                    <div
                        class="space-y-2 font-sans text-xs leading-relaxed text-slate-300 dark:text-slate-400"
                    >
                        <div class="flex items-start gap-2">
                            <MapPin
                                class="mt-0.5 h-3.5 w-3.5 shrink-0 text-brand-orange"
                            />
                            <span
                                >Jln Raya Tayu - Jepara KM. 7, Kec. Cluwak,
                                Kabupaten Pati, Jawa Tengah, Indonesia</span
                            >
                        </div>
                        <p class="text-[10px] font-bold text-slate-400">
                            (Siap melayani pertemuan tatap muka langsung di area
                            Tayu, Pati kota, Juwana, Margoyoso, Cluwak, Jepara
                            kota, Kudus, dan sekitarnya)
                        </p>
                    </div>
                </div>

                <!-- Navigation Quick links -->
                <div class="space-y-3 md:col-span-3">
                    <h5
                        class="font-sans text-xs font-bold tracking-widest text-white uppercase"
                    >
                        KONTAK &amp; LAYANAN
                    </h5>
                    <div
                        class="space-y-2.5 font-sans text-xs text-slate-300 dark:text-slate-400"
                    >
                        <div class="flex items-center gap-2">
                            <PhoneCall
                                class="h-3.5 w-3.5 shrink-0 text-brand-orange"
                            />
                            <span
                                >WhatsApp:
                                <a
                                    :href="directWaUrl"
                                    target="_blank"
                                    class="font-bold text-brand-orange hover:text-orange-400 hover:underline"
                                    >+62 857-9935-2991</a
                                >
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <Mail
                                class="h-3.5 w-3.5 shrink-0 text-brand-orange"
                            />
                            <span>Email: miftahulumam862@gmail.com</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <Clock
                                class="h-3.5 w-3.5 shrink-0 text-brand-orange"
                            />
                            <span>Operasional: 08:00 - 20:00 WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Credits -->
            <div
                class="mx-auto mt-10 flex max-w-7xl flex-col items-center justify-between border-t border-slate-800/80 px-6 pt-10 font-sans text-[11px] text-slate-400 sm:flex-row"
            >
                <p>
                    © 2026 JasaWeb Cluwak. Hak Cipta Dilindungi Undang-Undang.
                </p>
                <div class="mt-4 flex gap-4 font-medium sm:mt-0">
                    <a href="#projek" class="transition hover:text-brand-orange"
                        >Projek</a
                    >
                    <a
                        href="#pricing"
                        class="transition hover:text-brand-orange"
                        >Harga</a
                    >
                </div>
            </div>
        </footer>

        <!-- Floating WhatsApp Interactive Widget -->
        <WhatsAppCTA />
    </div>
</template>
