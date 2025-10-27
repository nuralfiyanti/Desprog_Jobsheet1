# Gunakan image Node.js LTS sebagai base
FROM node:lts-alpine

# Set direktori kerja di dalam container
WORKDIR /usr/src/app

# Salin package.json dan package-lock.json (jika ada)
# Ini memungkinkan caching untuk node_modules jika dependencies tidak berubah
COPY package*.json ./

# Install dependencies
RUN npm install --omit=dev

# Salin sisa kode aplikasi
# Pastikan folder 'routes' dan 'db' juga ikut tersalin
COPY . .

# Expose port aplikasi (sesuai dengan PORT di server.js, yaitu 3000)
EXPOSE 3000

# Perintah untuk menjalankan aplikasi
CMD ["npm", "start"]
