#!/usr/bin/env bash
set -euo pipefail
CF="${CLOUDFLARED:-$HOME/.local/bin/cloudflared}"
if [[ ! -x "$CF" ]]; then
  echo "Không thấy cloudflared. Cài: scripts/cloudflare-tunnel/setup-cloudflared.sh"
  exit 1
fi
if [[ ! -f "$HOME/.cloudflared/config.yml" ]]; then
  echo "Chưa có ~/.cloudflared/config.yml"
  echo "Xem mẫu: $(dirname "$0")/config.yml.example"
  exit 1
fi
exec "$CF" tunnel --config "$HOME/.cloudflared/config.yml" run
