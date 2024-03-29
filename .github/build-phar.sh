#!/bin/sh

# This file is part of the PPCRE.
#
# (c) Serghei Iakovlev <egrep@protonmail.ch>
#
# For the full copyright and license information, please view
# the LICENSE file that was distributed with this source code.

# -e  Exit immediately if a command exits with a non-zero status.
# -u  Treat unset variables as an error when substituting.
set -eu

if [ "$(command -v box 2>/dev/null || true)" = "" ]; then
  (>&2 printf "To use this script you need to install humbug/box: %s \\n" \
    "https://github.com/humbug/box")
  (>&2 echo "Aborting.")
  exit 1
fi

box validate || exit 1
box compile  || exit 1

if [ ! -f "./jose.phar" ] || [ ! -x "./jose.phar" ]; then
  (>&2 echo "Something went wrong when building jose.phar")
  (>&2 echo "Aborting.")
  exit 1
fi
