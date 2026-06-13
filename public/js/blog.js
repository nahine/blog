/* ============================================================
   Blog — interactions AJAX (like / commentaire / réponse)
   Aucune dépendance : Fetch API + vanilla JS
   ============================================================ */
(function () {
    'use strict';

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    /* ---------- Toasts ---------- */
    function toast(message, type = 'success') {
        let stack = document.querySelector('.toast-stack');
        if (!stack) {
            stack = document.createElement('div');
            stack.className = 'toast-stack';
            document.body.appendChild(stack);
        }
        const icons = {
            success: 'bi-check-circle-fill',
            error: 'bi-exclamation-triangle-fill',
            info: 'bi-info-circle-fill',
        };
        const el = document.createElement('div');
        el.className = 'app-toast ' + type;
        el.innerHTML = `<i class="bi ${icons[type] || icons.info} ti"></i><span>${message}</span>`;
        stack.appendChild(el);
        setTimeout(() => {
            el.classList.add('hide');
            el.addEventListener('animationend', () => el.remove(), { once: true });
        }, 3500);
    }
    window.blogToast = toast;

    /* ---------- Helper fetch JSON ---------- */
    async function postJson(url, body) {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify(body || {}),
        });
        if (res.status === 419) throw new Error('Session expirée, veuillez recharger la page.');
        if (res.status === 401) throw new Error('Vous devez être connecté pour effectuer cette action.');
        if (res.status === 403) throw new Error('Vous devez confirmer votre adresse email pour interagir.');
        const data = await res.json().catch(() => ({}));
        if (!res.ok || data.success === false) {
            const msg = data.message || (data.errors ? Object.values(data.errors)[0][0] : 'Une erreur est survenue.');
            throw new Error(msg);
        }
        return data;
    }

    function updateCommentCounts(count) {
        document.querySelectorAll('[data-comments-count]').forEach((el) => {
            el.textContent = count;
        });
    }

    document.addEventListener('DOMContentLoaded', function () {

        /* ---------- LIKE ---------- */
        const likeForm = document.querySelector('.like-form');
        if (likeForm) {
            likeForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const btn = likeForm.querySelector('.btn-like');
                btn.disabled = true;
                try {
                    const data = await postJson(likeForm.action);
                    const countEls = document.querySelectorAll('[data-likes-count]');
                    countEls.forEach((el) => (el.textContent = data.likes_count));

                    const label = btn.querySelector('.like-label');
                    btn.classList.toggle('is-liked', data.liked);
                    btn.classList.add('pop');
                    setTimeout(() => btn.classList.remove('pop'), 500);
                    if (label) label.textContent = data.liked ? "Vous aimez cet article" : "J'aime cet article";
                    toast(data.liked ? 'Merci pour votre like !' : 'Like retiré.', 'success');
                } catch (err) {
                    toast(err.message, 'error');
                } finally {
                    btn.disabled = false;
                }
            });
        }

        /* ---------- COMMENTAIRE ---------- */
        const commentForm = document.querySelector('#comment-form');
        if (commentForm) {
            commentForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const btn = commentForm.querySelector('button[type="submit"]');
                const textarea = commentForm.querySelector('textarea[name="body"]');
                if (!textarea.value.trim()) return;
                btn.disabled = true;
                try {
                    const data = await postJson(commentForm.action, { body: textarea.value });
                    const list = document.querySelector('#comments-list');
                    const empty = document.querySelector('#comments-empty');
                    if (empty) empty.remove();
                    if (list && data.html) list.insertAdjacentHTML('afterbegin', data.html);
                    textarea.value = '';
                    if (typeof data.comments_count !== 'undefined') updateCommentCounts(data.comments_count);
                    toast(data.message || 'Commentaire publié !', 'success');
                } catch (err) {
                    toast(err.message, 'error');
                } finally {
                    btn.disabled = false;
                }
            });
        }

        /* ---------- RÉPONSE (délégation) ---------- */
        document.addEventListener('submit', async function (e) {
            const form = e.target.closest('.reply-form');
            if (!form) return;
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            const textarea = form.querySelector('textarea[name="body"]');
            if (!textarea.value.trim()) return;
            btn.disabled = true;
            try {
                const data = await postJson(form.action, { body: textarea.value });
                const commentId = form.dataset.comment;
                const wrap = document.querySelector('#replies-' + commentId);
                if (wrap && data.html) wrap.insertAdjacentHTML('beforeend', data.html);
                textarea.value = '';
                const box = document.querySelector('#reply-' + commentId);
                if (box) box.style.display = 'none';
                if (typeof data.comments_count !== 'undefined') updateCommentCounts(data.comments_count);
                toast(data.message || 'Réponse publiée !', 'success');
            } catch (err) {
                toast(err.message, 'error');
            } finally {
                btn.disabled = false;
            }
        });
    });

    /* ---------- Afficher / masquer le mot de passe ---------- */
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.pwd-toggle');
        if (!btn) return;
        const input = btn.closest('.pwd-wrap')?.querySelector('input');
        if (!input) return;
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        const icon = btn.querySelector('i');
        if (icon) icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
        btn.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
    });

    /* ---------- Toggle formulaire de réponse ---------- */
    window.toggleReply = function (commentId) {
        const box = document.getElementById('reply-' + commentId);
        if (!box) return;
        const visible = box.style.display !== 'none' && box.style.display !== '';
        box.style.display = visible ? 'none' : 'block';
        if (!visible) {
            setTimeout(() => box.querySelector('textarea')?.focus(), 50);
        }
    };
})();
