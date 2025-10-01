#!/bin/sh

# see https://nckrtl.com/articles/how-to-make-laravel-horizon-work-perfectly-with-any-docker-image

exec php /app/artisan horizon &

HORIZON_PID=$!

stop_horizon() {
  php /app/artisan horizon:terminate --wait
  exit 0
}

trap 'stop_horizon' TERM

# This wait ensures the script itself does not exit until Horizon process is done
wait $HORIZON_PID

exit 0
