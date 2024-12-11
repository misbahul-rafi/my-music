FROM python:3.9-slim

RUN apt-get update && apt-get install -y \
    ffmpeg \
    supervisor \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
    
WORKDIR /home/app
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt
COPY . .
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
EXPOSE 5000

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]