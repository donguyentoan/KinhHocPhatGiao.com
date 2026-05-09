#!/usr/bin/env bash
# Cài cloudflared (binary GitHub) + hướng dẫn đăng nhập Cloudflare & chạy tunnel.
set -euo pipefail

ARCH="$(uname -m)"
case "$ARCH" in
  x86_64) PKG="cloudflared-darwin-amd64.tgz" ;;
  arm64)  PKG="cloudflared-darwin-arm64.tgz" ;;
  *) echo "Kiến trúc không hỗ trợ: $ARCH"; exit 1 ;;
esac

BIN_DIR="${HOME}/.local/bin"
mkdir -p "$BIN_DIR"
CF="$BIN_DIR/cloudflared"

if [[ ! -x "$CF" ]]; then
  echo "Đang tải cloudflared ($PKG)..."
  curl -fsSL "https://github.com/cloudflare/cloudflared/releases/latest/download/${PKG}" -o /tmp/cloudflared.tgz
  tar -xzf /tmp/cloudflared.tgz -C "$BIN_DIR"
  chmod +x "$CF"
fi

echo "cloudflared: $($CF version)"
echo ""
echo "=== Bước tiếp theo (bạn chạy tay trong Terminal) ==="
echo ""
echo "1) Thêm PATH (tạm thời hoặc ghi vào ~/.zshrc / ~/.bash_profile):"
echo "   export PATH=\"\$HOME/.local/bin:\$PATH\""
echo ""
echo "2) Đăng nhập Cloudflare (mở link trong trình duyệt):"
echo "   cloudflared tunnel login"
echo ""
echo "3) Tạo tunnel:"
echo "   cloudflared tunnel create kinhhocphatgiaocom"
echo "   (ghi lại UUID tunnel)"
echo ""
echo "4) Tạo ~/.cloudflared/config.yml — copy từ:"
echo "   $(cd "$(dirname "$0")" && pwd)/config.yml.example"
echo "   Điền: tunnel UUID, credentials-file đúng đường dẫn, hostname (DNS Cloudflare),"
echo "   service = http://127.0.0.1:PORT (PORT lấy trong Local WP),"
echo "   httpHostHeader: kinhhocphatgiaocom.local"
echo ""
echo "5) Trên Cloudflare DNS: CNAME  hostname  →  <UUID>.cfargotunnel.com  (proxy bật)"
echo ""
echo "6) Chạy tunnel:"
echo "   $(cd "$(dirname "$0")" && pwd)/run-tunnel.sh"
echo ""
