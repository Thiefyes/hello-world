import subprocess
import requests
import time
import os
import signal

SERVER = None


def setup_module(module):
    subprocess.run(['mysql', 'cms', '-u', 'root', '-e', 'TRUNCATE TABLE pages;'])
    global SERVER
    SERVER = subprocess.Popen(['php', '-S', '127.0.0.1:8000', '-t', 'backend'], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    time.sleep(1)


def teardown_module(module):
    if SERVER:
        SERVER.terminate()
        SERVER.wait()


def test_crud():
    base = 'http://127.0.0.1:8000/api.php'

    r = requests.get(base)
    assert r.status_code == 200
    assert r.json() == []

    r = requests.post(base, json={'title': 'Test', 'content': '<p>Hello</p>'})
    assert r.status_code == 200
    new_id = r.json()['id']

    r = requests.get(f'{base}?id={new_id}')
    assert r.status_code == 200
    assert r.json()['title'] == 'Test'

    r = requests.put(f'{base}?id={new_id}', json={'title': 'New', 'content': '<p>Updated</p>'})
    assert r.status_code == 200

    r = requests.get(f'{base}?id={new_id}')
    assert r.json()['title'] == 'New'

    r = requests.delete(f'{base}?id={new_id}')
    assert r.status_code == 200

    r = requests.get(base)
    assert r.json() == []

