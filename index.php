<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Pendaftaran Penerbangan</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Open Sans -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
        url('https://d1csarkz8obe9u.cloudfront.net/posterpreviews/singapore-changi-airport-design-template-8aee4eb0c67a312f981a62259436cd94_screen.jpg?ts=1646709971') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      min-height: 100vh;
    }

    .form-container {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
      color: #333;
    }

    h2 {
      color: #14279B;
      margin-bottom: 30px;
    }

    .icon {
      margin-right: 8px;
      color: #14279B;
    }

    .price-preview {
      font-style: italic;
      color: #444;
    }

    .output {
      background-color: #f4f4f4;
      padding: 20px;
      border-radius: 15px;
      box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 25px;
    }

    button:hover {
      background-color: #0f1f7a !important;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="col-md-8 col-lg-6 mx-auto form-container">
      <h2 class="text-center"><i class="fas fa-plane-departure icon"></i>Form Pendaftaran Penerbangan</h2>
      <form id="flightForm">
        <div class="mb-3">
          <label for="maskapai" class="form-label"><i class="fas fa-building icon"></i> Pilih Maskapai</label>
          <select id="maskapai" name="maskapai" class="form-select" required onchange="updateKelas()">
            <option value="">-- Pilih Maskapai --</option>
            <option value="MikyWays">MikyWays</option>
            <option value="FlyWithZoeey">FlyWithZoeey</option>
            <option value="Larooon">Larooon</option>
            <option value="JE and JE">JE and JE</option>
            <option value="SkyFINN">SkyFINN</option>
            <option value="TheMilles">TheMilles</option>
            <option value="GebyAirlines">GebyAirlines</option>
            <option value="CheyrenWave">CheyrenWave</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="kelas" class="form-label"><i class="fas fa-chair icon"></i> Kelas Tiket</label>
          <select id="kelas" name="kelas" class="form-select" required onchange="tampilkanPreviewHarga()">
            <option value="">-- Pilih Kelas --</option>
          </select>
        </div>

        <div id="previewHarga" class="price-preview mb-3"></div>

        <div class="mb-3">
          <label for="tanggal" class="form-label"><i class="fas fa-calendar-alt icon"></i> Tanggal Keberangkatan</label>
          <input type="date" id="tanggal" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="asal" class="form-label"><i class="fas fa-plane icon"></i> Bandara Asal</label>
          <select id="asal" name="asal" class="form-select" required></select>
        </div>

        <div class="mb-3">
          <label for="tujuan" class="form-label"><i class="fas fa-flag icon"></i> Bandara Tujuan</label>
          <select id="tujuan" name="tujuan" class="form-select" required></select>
        </div>

        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-ticket-alt icon"></i> Submit</button>
      </form>

      <div class="output mt-4" id="output"></div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const bandaraAsal = {
      'Soekarno Hatta': 65000,
      'Husein Sastranegara': 50000,
      'Abdul Rachman Saleh': 40000,
      'Juanda': 30000
    };

    const bandaraTujuan = {
      'Ngurah Rai': 85000,
      'Hasanuddin': 70000,
      'Inanwatan': 90000,
      'Sultan Iskandar Muda': 60000
    };

    const hargaMaskapai = {
      'MikyWays': [1200000, 4000000],
      'FlyWithZoeey': [1000000, 3800000],
      'Larooon': [1300000, 5500000],
      'JE and JE': [1200000, 4100000],
      'SkyFINN': [800000, 5000000],
      'TheMilles': [1000000, 3400000],
      'GebyAirlines': [990000, 3500000],
      'CheyrenWave': [1200000, 4500000]
    };

    const kelasOptions = ['Ekonomi', 'Bisnis', 'First Class'];
    const asalSelect = document.getElementById('asal');
    const tujuanSelect = document.getElementById('tujuan');
    const kelasSelect = document.getElementById('kelas');
    const form = document.getElementById('flightForm');
    const output = document.getElementById('output');
    const previewHarga = document.getElementById('previewHarga');

    Object.keys(bandaraAsal).sort().forEach(b => {
      const option = document.createElement('option');
      option.value = b;
      option.textContent = b;
      asalSelect.appendChild(option);
    });

    Object.keys(bandaraTujuan).sort().forEach(b => {
      const option = document.createElement('option');
      option.value = b;
      option.textContent = b;
      tujuanSelect.appendChild(option);
    });

    function updateKelas() {
      kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
      kelasOptions.forEach(k => {
        const option = document.createElement('option');
        option.value = k;
        option.textContent = k;
        kelasSelect.appendChild(option);
      });
      previewHarga.innerHTML = '';
    }

    function tampilkanPreviewHarga() {
      const maskapai = form.maskapai.value;
      const kelas = form.kelas.value;
      if (!maskapai || !kelas) {
        previewHarga.innerHTML = '';
        return;
      }

      const [min, max] = hargaMaskapai[maskapai];
      let harga = min;
      if (kelas === 'Bisnis') harga = Math.round(min + (max - min) * 0.5);
      if (kelas === 'First Class') harga = max;

      previewHarga.innerHTML = `Perkiraan harga untuk kelas <strong>${kelas}</strong>: Rp ${harga.toLocaleString()}`;
    }

    function generateNomorTiket() {
      const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      let result = 'CIHUY-';
      for (let i = 0; i < 6; i++) {
        result += chars[Math.floor(Math.random() * chars.length)];
      }
      return result;
    }

    form.addEventListener('submit', function(event) {
      event.preventDefault();

      const maskapai = form.maskapai.value;
      const asal = form.asal.value;
      const tujuan = form.tujuan.value;
      const kelas = form.kelas.value;
      const tanggal = form.tanggal.value;

      if (!maskapai || !asal || !tujuan || !kelas || !tanggal || asal === tujuan) {
        alert('Lengkapi data dengan benar dan pastikan asal ≠ tujuan');
        return;
      }

      const pajak = bandaraAsal[asal] + bandaraTujuan[tujuan];
      const [min, max] = hargaMaskapai[maskapai];
      let baseHarga = min;
      if (kelas === 'Bisnis') baseHarga = Math.round(min + (max - min) * 0.5);
      else if (kelas === 'First Class') baseHarga = max;

      const hargaTiket = Math.round(baseHarga);
      const total = hargaTiket + pajak;
      const nomorTiket = generateNomorTiket();

      output.innerHTML = `
        <h4><i class="fas fa-receipt icon"></i> Rincian Tiket:</h4>
        <p><strong>Nomor Tiket:</strong> ${nomorTiket}</p>
        <p><strong>Tanggal Keberangkatan:</strong> ${tanggal}</p>
        <p><strong>Maskapai:</strong> ${maskapai}</p>
        <p><strong>Kelas:</strong> ${kelas}</p>
        <p><strong>Asal:</strong> ${asal}</p>
        <p><strong>Tujuan:</strong> ${tujuan}</p>
        <p><strong>Harga Tiket:</strong> Rp ${hargaTiket.toLocaleString()}</p>
        <p><strong>Pajak:</strong> Rp ${pajak.toLocaleString()}</p>
        <p><strong>Total Bayar:</strong> <strong>Rp ${total.toLocaleString()}</strong></p>
      `;
    });
  </script>
</body>
</html>
