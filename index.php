<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Jadwal OSCE untuk lokal</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    /* Import Font */
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Orbitron:wght@700&display=swap');

    :root {
        --primary-bg: #f4f7f9;
        --sidebar-bg: #ffffff;
        --main-bg: #ffffff;
        --header-bg: #2c3e50;
        --accent-color: #3498db;
        --text-dark: #333;
        --border-color: #e1e5e8;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background-color: var(--primary-bg);
        margin: 0;
        color: var(--text-dark);
        height: 100vh;
        overflow: hidden;
    }

    .dashboard-container {
        display: flex;
        height: 100vh;
    }

    /* === Sidebar (Kolom Kiri) === */
    .sidebar {
        width: 400px;
        flex-shrink: 0;
        background-color: var(--sidebar-bg);
        border-right: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .sidebar-header {
        padding: 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar-header h3 {
        margin: 0;
        font-size: 1.2rem;
        color: var(--header-bg);
    }

    .station-count {
        background-color: var(--accent-color);
        color: white;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .schedule-list {
        list-style: none;
        padding: 0;
        margin: 0;
        overflow-y: auto;
        flex-grow: 1;
    }

    .schedule-list li {
        padding: 12px 20px;
        border-bottom: 1px solid var(--border-color);
        position: relative;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: background-color 0.3s;
    }

    .schedule-list li.station-start {
        border-top: 2px solid var(--accent-color);
        background-color: #eaf5fb;
        font-weight: bold;
    }

    .schedule-list li.active {
        background-color: #fffbe6;
        font-weight: 700;
    }

    .schedule-list li.played {
        background-color: #f8f9f9;
        color: #b0b0b0;
        opacity: 0.7;
    }

    .schedule-list li.played .item-text {
        text-decoration: line-through;
    }

    .schedule-list li.played .item-status-icon {
        color: #b0b0b0;
    }

    .item-status-icon {
        font-size: 1rem;
        color: #7f8c8d;
        width: 20px;
        text-align: center;
    }

    .item-status-icon.played-icon {
        color: #27ae60;
    }

    .item-time {
        font-weight: 700;
        margin-right: 10px;
    }

    /* === Main Content (Kolom Kanan) === */
    .main-content {
        flex-grow: 1;
        padding: 20px 40px;
        display: flex;
        flex-direction: column;
        height: 100vh;
        box-sizing: border-box;
    }

    .main-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }

    .main-header h1 {
        margin: 0;
        font-size: 1.8rem;
        color: var(--header-bg);
    }

    .clock {
        font-family: 'Orbitron', sans-serif;
        font-size: 2rem;
        background-color: var(--primary-bg);
        padding: 5px 15px;
        border-radius: 8px;
    }

    .countdown-wrapper {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .countdown-label {
        font-size: 1.2rem;
        color: #7f8c8d;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .countdown-timer {
        font-family: 'Orbitron', sans-serif;
        font-size: 7rem;
        font-weight: 700;
        color: var(--accent-color);
        line-height: 1;
    }

    .next-schedule-text {
        font-size: 1.5rem;
        margin-top: 15px;
        color: var(--text-dark);
    }

    .status-panel {
        text-align: center;
        margin-bottom: 20px;
    }

    .status-badge {
        padding: 8px 15px;
        border-radius: 20px;
        color: white;
        font-weight: 700;
    }

    .status-idle {
        background-color: #7f8c8d;
    }

    .status-running {
        background-color: #27ae60;
    }

    .status-playing {
        background-color: #e67e22;
    }

    .main-footer {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
        font-size: 0.9rem;
        color: #7f8c8d;
    }

    /* === TAMPILAN STATUS AUDIO === */
    .audio-playing-status {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: var(--accent-color);
    }

    .audio-icon {
        font-size: 7rem;
        line-height: 1;
        animation: bounce 1.5s ease-in-out infinite;
    }

    .audio-playing-text {
        font-size: 1.5rem;
        font-weight: 500;
        margin-top: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-20px);
        }

        60% {
            transform: translateY(-10px);
        }
    }

    /* === LAPISAN PEMBUKA === */
    .startup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(44, 62, 80, 0.95);
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        transition: opacity 0.5s ease, visibility 0.5s;
    }

    .startup-box {
        padding: 40px;
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 15px;
    }

    .startup-box h1 {
        font-size: 2.5rem;
        margin: 0;
    }

    .startup-box p {
        font-size: 1.2rem;
        opacity: 0.9;
    }

    .start-button {
        background-color: #27ae60;
        color: white;
        border: none;
        padding: 15px 40px;
        font-size: 1.5rem;
        font-weight: 700;
        border-radius: 10px;
        cursor: pointer;
        margin: 20px 0;
        transition: background-color 0.3s, transform 0.2s;
    }

    .start-button:hover {
        background-color: #2ecc71;
        transform: scale(1.05);
    }

    .small-text {
        font-size: 0.9rem;
        opacity: 0.7;
    }

    .hidden {
        display: none !important;
    }
</style>

<body>
    <div id="startup-overlay" class="startup-overlay">
        <div class="startup-box">
            <h1>OSCE UMSIDA KEDOKTERAN</h1>
            <p>Sistem Jadwal Audio Otomatis</p>
            <button id="start-system-button" class="start-button">▶ Mulai Sistem</button>
            <p class="small-text">Klik tombol ini untuk mengizinkan audio dan memulai sinkronisasi waktu.</p>
        </div>
    </div>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h3>🗓️ Daftar Jadwal</h3>
                <span id="station-count" class="station-count"></span>
            </div>
            <ul id="schedule-list" class="schedule-list">
            </ul>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h1>OSCE UMSIDA KEDOKTERAN</h1>
                <div id="live-clock" class="clock">00:00:00</div>
            </header>

            <div class="countdown-wrapper">
                <div id="countdown-container">
                    <div class="countdown-label">WAKTU MENUJU JADWAL BERIKUTNYA</div>
                    <div id="countdown-timer" class="countdown-timer">--:--:--</div>
                    <div id="next-schedule-text" class="next-schedule-text">Menunggu sistem dimulai...</div>
                </div>
                <div id="audio-playing-status" class="audio-playing-status hidden">
                    <div class="audio-icon">🔊</div>
                    <div class="audio-playing-text">AUDIO SEDANG BERBUNYI</div>
                </div>
            </div>

            <div class="status-panel">
                <h4>Status Sistem: <span id="system-status" class="status-badge status-idle">IDLE</span></h4>
            </div>

            <footer class="main-footer">
                Sistem berjalan secara otomatis.
            </footer>
        </main>
    </div>

    <audio id="ringtone-awal" src="ringtone-awal.mp3" preload="auto"></audio>
    <audio id="ringtone-akhir" src="ringtone-akhir.mp3" preload="auto"></audio>

    <script>
        // =================================================================
        // KONFIGURASI DAN DATA STASIUN (MODEL DINAMIS)
        // =================================================================

        /**
         * 💡 ATUR JADWAL OSCE DI SINI
         * - name: Nama stasiun yang akan ditampilkan.
         * - durationInMinutes: Durasi total stasiun DALAM RUANGAN (dalam menit).
         * - readDurationInMinutes: Waktu untuk BACA SOAL di luar ruangan (dalam menit).
         * - warningTimeInMinutes: Peringatan akan dibunyikan sekian menit SEBELUM waktu habis.
         */
        const stationConfiguration = [{
                name: "STASIUN 1: Anamnesis",
                durationInMinutes: 10,
                readDurationInMinutes: 1,
                warningTimeInMinutes: 3
            },
            {
                name: "STASIUN 2: Pemeriksaan Fisik",
                durationInMinutes: 12,
                readDurationInMinutes: 1,
                warningTimeInMinutes: 3
            },
            {
                name: "STASIUN 3: Tatalaksana",
                durationInMinutes: 10,
                readDurationInMinutes: 2,
                warningTimeInMinutes: 2
            },
            {
                name: "STASIUN 4: Edukasi Pasien",
                durationInMinutes: 8,
                readDurationInMinutes: 1,
                warningTimeInMinutes: 3
            },
            {
                name: "STASIUN 5: Keterampilan Prosedural",
                durationInMinutes: 15,
                readDurationInMinutes: 2,
                warningTimeInMinutes: 5
            },
            // Tambahkan stasiun lain sebanyak yang Anda butuhkan
        ];

        // Waktu mulai stasiun pertama
        const OSCE_START_TIME = "08:00:00";

        // =================================================================
        // ELEMEN DOM DAN VARIABEL STATE
        // =================================================================
        const startupOverlay = document.getElementById('startup-overlay');
        const startSystemButton = document.getElementById('start-system-button');
        const liveClockEl = document.getElementById('live-clock');
        const scheduleListEl = document.getElementById('schedule-list');
        const stationCountEl = document.getElementById('station-count');
        const countdownContainer = document.getElementById('countdown-container');
        const audioPlayingStatus = document.getElementById('audio-playing-status');
        const countdownTimerEl = document.getElementById('countdown-timer');
        const nextScheduleTextEl = document.getElementById('next-schedule-text');
        const systemStatusEl = document.getElementById('system-status');
        const ringtoneAwal = document.getElementById('ringtone-awal');
        const ringtoneAkhir = document.getElementById('ringtone-akhir');
        const synth = window.speechSynthesis;

        let flatSchedule = [];
        let isPlaying = false;
        let mainInterval = null;

        // =================================================================
        // FUNGSI GENERATOR DAN UTILITY
        // =================================================================

        function timeStringToDate(timeString) {
            const now = new Date();
            const [h, m, s] = timeString.split(':');
            return new Date(now.getFullYear(), now.getMonth(), now.getDate(), h, m, s);
        }

        function dateToTimeString(date) {
            return date.toTimeString().split(' ')[0];
        }

        function generateScheduleFromStations() {
            const generatedSchedule = [];
            let currentStartTime = timeStringToDate(OSCE_START_TIME);
            let lastEventEndTime = null;

            const pembukaanTime = new Date(currentStartTime.getTime() - 2 * 60 * 1000);
            generatedSchedule.push({
                displayText: `PERSIAPAN DIMULAI`,
                audioText: `Sesi akan dimulai dalam 2 menit`,
                time: dateToTimeString(pembukaanTime),
                isStationStart: true,
            });

            stationConfiguration.forEach((station) => {
                const readDuration = station.readDurationInMinutes || 1;
                const warningTime = station.warningTimeInMinutes || 3;
                const stationDurationSeconds = station.durationInMinutes * 60;

                const bacaSoalTime = new Date(currentStartTime.getTime() - readDuration * 60 * 1000);
                generatedSchedule.push({
                    displayText: `Baca Soal: ${station.name} (${readDuration} mnt)`,
                    audioText: station.name,
                    time: dateToTimeString(bacaSoalTime),
                    isStationStart: true,
                });
                generatedSchedule.push({
                    displayText: `Masuk Ruangan: ${station.name}`,
                    audioText: station.name,
                    time: dateToTimeString(currentStartTime),
                });
                if (station.durationInMinutes > warningTime) {
                    const warningTimeInSeconds = warningTime * 60;
                    const warningTriggerTime = new Date(currentStartTime.getTime() + (stationDurationSeconds - warningTimeInSeconds) * 1000);
                    generatedSchedule.push({
                        displayText: `Peringatan di ${station.name}`,
                        audioText: `Waktu kurang ${warningTime} menit`,
                        time: dateToTimeString(warningTriggerTime),
                    });
                }
                const endTime = new Date(currentStartTime.getTime() + stationDurationSeconds * 1000);
                generatedSchedule.push({
                    displayText: `Waktu Habis: ${station.name}`,
                    audioText: station.name,
                    time: dateToTimeString(endTime),
                });
                lastEventEndTime = endTime;
                currentStartTime = new Date(endTime.getTime() + readDuration * 60 * 1000);
            });

            if (lastEventEndTime) {
                const penutupTime = new Date(lastEventEndTime.getTime() + 15 * 1000);
                generatedSchedule.push({
                    displayText: `SESI SELESAI`,
                    audioText: `Seluruh sesi telah selesai. Terima kasih.`,
                    time: dateToTimeString(penutupTime),
                });
            }
            return generatedSchedule;
        }

        function loadAndProcessSchedule() {
            flatSchedule = generateScheduleFromStations();
            const now = new Date();
            const currentTimeString = dateToTimeString(now);
            flatSchedule.forEach(item => {
                item.hasBeenPlayed = item.time < currentTimeString;
                item.timeInSeconds = timeStringToSeconds(item.time);
            });
        }

        function timeStringToSeconds(timeString) {
            const [h, m, s] = timeString.split(':').map(Number);
            return h * 3600 + m * 60 + s;
        }

        function formatSecondsToTime(seconds) {
            if (isNaN(seconds) || seconds < 0) return "00:00:00";
            const h = Math.floor(seconds / 3600);
            const m = Math.floor((seconds % 3600) / 60);
            const s = Math.floor(seconds % 60);
            return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        }

        // =================================================================
        // FUNGSI RENDER DAN PEMUTARAN AUDIO (DENGAN LOGIKA UI BARU)
        // =================================================================

        function renderScheduleList() {
            scheduleListEl.innerHTML = '';
            stationCountEl.textContent = `Total: ${stationConfiguration.length} Stasiun`;
            flatSchedule.forEach((item, index) => {
                const li = document.createElement('li');
                const icon = item.hasBeenPlayed ? '✔' : '🕒';
                li.innerHTML = `
            <span class="item-status-icon ${item.hasBeenPlayed ? 'played-icon' : ''}">${icon}</span>
            <div>
                <span class="item-time">${item.time}</span>
                <span class="item-text">${item.displayText}</span>
            </div>
        `;
                if (item.hasBeenPlayed) li.classList.add('played');
                if (item.isStationStart) li.classList.add('station-start');
                li.dataset.index = index;
                scheduleListEl.appendChild(li);
            });
        }

        function setSystemStatus(status) {
            systemStatusEl.textContent = status.toUpperCase();
            systemStatusEl.className = 'status-badge';
            if (status === 'running') systemStatusEl.classList.add('status-running');
            else if (status === 'playing') systemStatusEl.classList.add('status-playing');
            else systemStatusEl.classList.add('idle');
        }

        async function playSequence(index) {
            if (isPlaying) return;
            isPlaying = true;
            setSystemStatus('playing');

            countdownContainer.classList.add('hidden');
            audioPlayingStatus.classList.remove('hidden');

            const item = flatSchedule[index];
            const listItem = scheduleListEl.querySelector(`li[data-index='${index}']`);
            if (listItem) listItem.classList.add('active');

            try {
                await new Promise((res, rej) => {
                    ringtoneAwal.onended = res;
                    ringtoneAwal.onerror = rej;
                    ringtoneAwal.play().catch(rej);
                });
                await new Promise((res, rej) => {
                    synth.cancel();
                    const utterance = new SpeechSynthesisUtterance(item.audioText);
                    utterance.lang = 'id-ID';
                    utterance.onend = res;
                    utterance.onerror = rej;
                    synth.speak(utterance);
                });
                await new Promise((res, rej) => {
                    ringtoneAkhir.onended = res;
                    ringtoneAkhir.onerror = rej;
                    ringtoneAkhir.play().catch(rej);
                });
            } catch (error) {
                console.error("Gagal memutar sekuens audio:", error);
            } finally {
                isPlaying = false;
                item.hasBeenPlayed = true;
                if (listItem) {
                    listItem.classList.remove('active');
                    listItem.classList.add('played');
                    listItem.querySelector('.item-status-icon').textContent = '✔';
                    listItem.querySelector('.item-status-icon').classList.add('played-icon');
                }
                setSystemStatus('running');

                audioPlayingStatus.classList.add('hidden');
                countdownContainer.classList.remove('hidden');
                systemTick();
            }
        }

        function systemTick() {
            const now = new Date();
            const currentTimeString = dateToTimeString(now);
            liveClockEl.textContent = currentTimeString;

            if (!isPlaying) {
                const itemToPlayIndex = flatSchedule.findIndex(item => item.time === currentTimeString && !item.hasBeenPlayed);
                if (itemToPlayIndex !== -1) {
                    playSequence(itemToPlayIndex);
                    return;
                }
            }

            // Bagian ini hanya akan berjalan jika audio tidak sedang berbunyi
            const nextItem = flatSchedule.find(item => !item.hasBeenPlayed);
            if (nextItem) {
                const currentSeconds = now.getHours() * 3600 + now.getMinutes() * 60 + now.getSeconds();
                let diffSeconds = nextItem.timeInSeconds - currentSeconds;
                if (diffSeconds < 0) {
                    diffSeconds += 86400; // Handle jadwal hari berikutnya
                }
                countdownTimerEl.textContent = formatSecondsToTime(diffSeconds);
                nextScheduleTextEl.textContent = nextItem.displayText;
            } else {
                countdownTimerEl.textContent = "SELESAI";
                nextScheduleTextEl.textContent = "Semua jadwal telah dijalankan.";
                setSystemStatus('idle');
                if (mainInterval) clearInterval(mainInterval);
            }
        }

        function initializeSystem() {
            setSystemStatus('running');
            loadAndProcessSchedule();
            renderScheduleList();
            if (mainInterval) clearInterval(mainInterval);
            systemTick();
            mainInterval = setInterval(systemTick, 1000);
        }

        // =================================================================
        // INISIALISASI HALAMAN
        // =================================================================
        startSystemButton.addEventListener('click', () => {
            startupOverlay.classList.add('hidden');
            const audioContext = new(window.AudioContext || window.webkitAudioContext)();
            if (audioContext.state === 'suspended') {
                audioContext.resume();
            }
            ringtoneAwal.play().then(() => {
                ringtoneAwal.pause();
                ringtoneAwal.currentTime = 0;
            });
            initializeSystem();
        });
    </script>
</body>

</html>