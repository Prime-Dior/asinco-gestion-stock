// ASINCO — Scripts front
(function () {
  // ---------- Store : persistance frontend (localStorage) ----------
  // Permet à la démo de se comporter comme une vraie app sans backend.
  // À supprimer / remplacer par les appels Oracle quand le back sera branché.
  const Store = {
    KEY: "asinco-store-v1",
    _cache: null,
    load() {
      if (this._cache) return this._cache;
      try { this._cache = JSON.parse(localStorage.getItem(this.KEY)) || {}; }
      catch { this._cache = {}; }
      return this._cache;
    },
    save() {
      try { localStorage.setItem(this.KEY, JSON.stringify(this._cache)); } catch {}
    },
    ns(name) {
      const d = this.load();
      d[name] = d[name] || {};
      return d[name];
    },
    addItem(resource, item) {
      const ns = this.ns(resource);
      ns.added = ns.added || [];
      ns.added.push(item);
      this.save();
    },
    deleteItem(resource, id) {
      const ns = this.ns(resource);
      ns.deleted = ns.deleted || [];
      if (!ns.deleted.includes(String(id))) ns.deleted.push(String(id));
      // Si l'élément avait été créé côté front, on le retire de added
      if (ns.added) ns.added = ns.added.filter(i => String(i.id) !== String(id));
      this.save();
    },
    isDeleted(resource, id) {
      const ns = this.ns(resource);
      return (ns.deleted || []).includes(String(id));
    },
    getAdded(resource) {
      return this.ns(resource).added || [];
    },
    setRename(resource, id, name) {
      const ns = this.ns(resource);
      ns.renamed = ns.renamed || {};
      ns.renamed[String(id)] = name;
      this.save();
    },
    getRename(resource, id) {
      const ns = this.ns(resource);
      return ns.renamed?.[String(id)] || null;
    },
    setPref(key, value) {
      const ns = this.ns("prefs");
      ns[key] = value;
      this.save();
    },
    getPref(key, fallback) {
      const ns = this.ns("prefs");
      return ns[key] === undefined ? fallback : ns[key];
    },
    nextId(resource) {
      // ID basé sur le timestamp pour éviter les collisions avec les IDs PHP
      return "u" + Date.now();
    },
  };
  window.ASINCO = window.ASINCO || {};
  window.ASINCO.Store = Store;

  // ---------- Theme manager ----------
  const ThemeManager = {
    KEY: "asinco-theme",
    get() { try { return localStorage.getItem(this.KEY) || "auto"; } catch { return "auto"; } },
    set(value) {
      try { localStorage.setItem(this.KEY, value); } catch {}
      this.apply(value);
    },
    apply(value) {
      const effective = value === "auto"
        ? (matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light")
        : value;
      document.documentElement.setAttribute("data-bs-theme", effective);
      document.documentElement.dataset.themePref = value;
      document.querySelectorAll("[data-theme-set]").forEach(b => {
        b.classList.toggle("is-active", b.dataset.themeSet === value);
      });
    },
    init() {
      this.apply(this.get());
      document.querySelectorAll("[data-theme-set]").forEach(btn => {
        btn.addEventListener("click", () => this.set(btn.dataset.themeSet));
      });
      // Suivre les changements système quand le mode auto est actif
      matchMedia("(prefers-color-scheme: dark)").addEventListener("change", () => {
        if (this.get() === "auto") this.apply("auto");
      });
    },
  };
  ThemeManager.init();
  window.ASINCO_Theme = ThemeManager;

  // Init Lucide icons (après le toggle pour que les icônes y soient rendues)
  if (window.lucide && typeof window.lucide.createIcons === "function") {
    window.lucide.createIcons();
  }

  // Confirm-delete modal : passer l'ID au lien de confirmation
  const deleteModal = document.getElementById("confirmDelete");
  if (deleteModal) {
    deleteModal.addEventListener("show.bs.modal", function (event) {
      const trigger = event.relatedTarget;
      const id = trigger?.getAttribute("data-id");
      const target = trigger?.getAttribute("data-target") || "#";
      const link = deleteModal.querySelector("#confirmDeleteLink");
      if (link) link.setAttribute("href", `${target}?delete=${encodeURIComponent(id)}`);
    });
  }

  // Toggle mobile sidebar (offcanvas non utilisé ici, simple toggle)
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".app-sidebar");
  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener("click", () => sidebar.classList.toggle("d-block"));
  }

  // Auto-dismiss alerts après 5s
  document.querySelectorAll(".alert.auto-dismiss").forEach(el => {
    setTimeout(() => {
      const a = bootstrap.Alert.getOrCreateInstance(el);
      a.close();
    }, 5000);
  });

  // Flip words — cycle animé d'une liste de mots dans un <span class="flip-words" data-words='[...]'>
  document.querySelectorAll(".flip-words").forEach(el => {
    let words;
    try { words = JSON.parse(el.dataset.words || "[]"); } catch { return; }
    if (!Array.isArray(words) || words.length < 2) return;
    const interval = parseInt(el.dataset.interval || "2800", 10);
    let i = 0;
    el.textContent = words[0];
    el.classList.add("is-in");
    setInterval(() => {
      el.classList.remove("is-in");
      el.classList.add("is-out");
      setTimeout(() => {
        i = (i + 1) % words.length;
        el.textContent = words[i];
        el.classList.remove("is-out");
        // reflow pour relancer l'animation
        void el.offsetWidth;
        el.classList.add("is-in");
      }, 320);
    }, interval);
  });

  // ---------- Dashboard interactif ----------
  // Tri sur les tableaux : <th data-sort> permet de trier en cliquant sur l'en-tête
  document.querySelectorAll("table[data-sortable]").forEach(table => {
    const tbody = table.querySelector("tbody");
    if (!tbody) return;
    table.querySelectorAll("thead th[data-sort]").forEach((th, idx) => {
      th.style.cursor = "pointer";
      th.addEventListener("click", () => {
        const dir = th.dataset.dir === "asc" ? "desc" : "asc";
        table.querySelectorAll("th[data-sort]").forEach(h => h.dataset.dir = "");
        th.dataset.dir = dir;
        const rows = Array.from(tbody.rows);
        rows.sort((a, b) => {
          const av = (a.cells[idx]?.dataset.value ?? a.cells[idx]?.innerText ?? "").trim();
          const bv = (b.cells[idx]?.dataset.value ?? b.cells[idx]?.innerText ?? "").trim();
          const numA = parseFloat(av), numB = parseFloat(bv);
          const cmp = !isNaN(numA) && !isNaN(numB)
            ? numA - numB
            : av.localeCompare(bv, "fr", { numeric: true });
          return dir === "asc" ? cmp : -cmp;
        });
        rows.forEach(r => tbody.appendChild(r));
      });
    });
  });

  // Filtre instantané des tableaux : <input data-filter-table="#id">
  document.querySelectorAll("[data-filter-table]").forEach(input => {
    const target = document.querySelector(input.dataset.filterTable);
    if (!target) return;
    input.addEventListener("input", () => {
      const q = input.value.toLowerCase().trim();
      target.querySelectorAll("tbody tr").forEach(row => {
        row.style.display = !q || row.innerText.toLowerCase().includes(q) ? "" : "none";
      });
    });
  });

  // ---------- Toast system ----------
  const toast = (message, opts = {}) => {
    const host = document.getElementById("asincoToastHost");
    if (!host) return;
    const variant = opts.variant || "success"; // success | warn | error
    const icons = { success: "check-circle", warn: "alert-triangle", error: "x-circle" };
    const el = document.createElement("div");
    el.className = `asinco-toast is-${variant}`;
    el.setAttribute("role", "status");
    el.innerHTML = `
      <span class="icon"><i data-lucide="${icons[variant] || "info"}"></i></span>
      <div class="body">
        ${opts.title ? `<div class="title">${opts.title}</div>` : ""}
        <div class="message"></div>
      </div>
      <button type="button" class="close" aria-label="Fermer"><i data-lucide="x"></i></button>
    `;
    el.querySelector(".message").textContent = message;
    host.appendChild(el);
    if (window.lucide) lucide.createIcons();
    const remove = () => {
      el.classList.add("is-leaving");
      setTimeout(() => el.remove(), 260);
    };
    el.querySelector(".close").addEventListener("click", remove);
    if (opts.duration !== 0) setTimeout(remove, opts.duration || 3500);
  };
  window.ASINCO = window.ASINCO || {};
  window.ASINCO.toast = toast;

  // ---------- Confirm modal global ----------
  const confirmModalEl = document.getElementById("globalConfirm");
  if (confirmModalEl && window.bootstrap) {
    const confirmModal = bootstrap.Modal.getOrCreateInstance(confirmModalEl);
    let pendingTrigger = null;

    const openConfirm = (trigger) => {
      pendingTrigger = trigger;
      const d = trigger.dataset;
      confirmModalEl.querySelector("#globalConfirmTitle").textContent = d.confirmTitle || "Confirmer l'action";
      confirmModalEl.querySelector("#globalConfirmMessage").innerHTML = d.confirmMessage || "Voulez-vous vraiment continuer ?";
      const cta = confirmModalEl.querySelector("#globalConfirmCta");
      cta.textContent = d.confirmCta || "Confirmer";
      confirmModalEl.dataset.variant = d.confirmVariant || "warn";
      // icône
      const icon = confirmModalEl.querySelector(".confirm-icon i");
      if (icon) {
        icon.setAttribute("data-lucide", d.confirmIcon || "alert-triangle");
        if (window.lucide) lucide.createIcons();
      }
      confirmModal.show();
    };

    document.addEventListener("click", (e) => {
      const trigger = e.target.closest("[data-confirm]");
      if (trigger) {
        e.preventDefault();
        openConfirm(trigger);
      }
    });

    confirmModalEl.querySelector("#globalConfirmCta").addEventListener("click", () => {
      if (!pendingTrigger) return confirmModal.hide();
      const d = pendingTrigger.dataset;
      const action = d.confirmAction;
      const href = d.confirmHref;

      // Action : suppression d'une ligne de tableau
      if (action === "delete-row") {
        const id = d.targetId;
        const resource = d.targetResource;
        const row = document.querySelector(`tr[data-row-id="${CSS.escape(id)}"]`);
        if (row) {
          row.classList.add("is-removing");
          setTimeout(() => row.remove(), 320);
        }
        if (resource && id) Store.deleteItem(resource, id);
        toast(`${d.targetLabel || "Élément"} supprimé.`, { title: "Suppression effectuée" });
      }
      // Action : suppression d'une catégorie (carte)
      else if (action === "delete-categorie") {
        const card = pendingTrigger.closest("[data-categorie-id]");
        const id = card?.dataset.categorieId;
        const col = card?.closest(".col-md-4");
        if (col) {
          col.classList.add("is-removing");
          setTimeout(() => col.remove(), 320);
        }
        const label = card?.querySelector(".cat-libelle")?.textContent.trim() || "Catégorie";
        if (id) Store.deleteItem("categories", id);
        toast(`« ${label} » supprimée.`, { title: "Suppression effectuée" });
      }
      // Sinon : navigation simple
      else if (href) {
        window.location.href = href;
      }
      pendingTrigger = null;
      confirmModal.hide();
    });
  }

  // ---------- Renommer une catégorie inline ----------
  document.addEventListener("click", (e) => {
    const btn = e.target.closest("[data-action='rename-categorie']");
    if (!btn) return;
    const card = btn.closest("[data-categorie-id]");
    const titleEl = card?.querySelector(".cat-libelle");
    if (!titleEl) return;
    const original = titleEl.textContent.trim();
    titleEl.setAttribute("contenteditable", "true");
    titleEl.focus();
    // sélectionner tout le contenu
    const range = document.createRange();
    range.selectNodeContents(titleEl);
    const sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);

    const finish = (commit) => {
      titleEl.setAttribute("contenteditable", "false");
      const value = titleEl.textContent.trim();
      if (!commit || value === "" || value === original) {
        titleEl.textContent = original;
        return;
      }
      titleEl.textContent = value;
      const id = card?.dataset.categorieId;
      if (id) Store.setRename("categories", id, value);
      toast(`Catégorie renommée en « ${value} ».`, { title: "Renommage" });
    };

    titleEl.addEventListener("keydown", function onKey(ev) {
      if (ev.key === "Enter") { ev.preventDefault(); titleEl.removeEventListener("keydown", onKey); finish(true); }
      else if (ev.key === "Escape") { titleEl.removeEventListener("keydown", onKey); finish(false); }
    });
    titleEl.addEventListener("blur", function onBlur() {
      titleEl.removeEventListener("blur", onBlur);
      finish(true);
    }, { once: true });
  });

  // ---------- Notifications : marquer tout lu (persisté) ----------
  const applyNotifsState = () => {
    if (!Store.getPref("notif.allRead", false)) return;
    document.querySelectorAll(".notif-list .notif-item").forEach(item => {
      item.style.opacity = "0.55";
    });
    const dot = document.querySelector("[aria-label='Notifications'] .bg-success");
    if (dot) dot.style.display = "none";
  };
  applyNotifsState();

  document.querySelectorAll("[data-action='mark-all-read']").forEach(btn => {
    btn.addEventListener("click", (e) => {
      e.stopPropagation();
      Store.setPref("notif.allRead", true);
      applyNotifsState();
      toast("Toutes les notifications marquées comme lues.", { title: "Notifications" });
    });
  });

  // ---------- Persistance : application au chargement de la page ----------

  // 1. Filtrer les éléments supprimés (côté front)
  document.querySelectorAll("[data-store-list]").forEach(list => {
    const resource = list.dataset.storeList;
    const ns = Store.ns(resource);
    const deleted = ns.deleted || [];

    // Pour les tableaux : retirer les <tr data-row-id>
    list.querySelectorAll("tr[data-row-id]").forEach(row => {
      if (deleted.includes(String(row.dataset.rowId))) row.remove();
    });
    // Pour les cartes (catégories) : retirer les .col[*] contenant un [data-categorie-id]
    list.querySelectorAll("[data-categorie-id]").forEach(card => {
      if (deleted.includes(String(card.dataset.categorieId))) {
        card.closest(".col-md-4")?.remove();
      }
    });
  });

  // 2. Appliquer les renommages (catégories)
  document.querySelectorAll("[data-categorie-id]").forEach(card => {
    const id = card.dataset.categorieId;
    const renamed = Store.getRename("categories", id);
    if (renamed) {
      const t = card.querySelector(".cat-libelle");
      if (t) t.textContent = renamed;
    }
  });

  // 3. Injecter les éléments ajoutés côté front
  // Matériels
  const materielsList = document.querySelector('[data-store-list="materiels"]');
  if (materielsList) {
    const tbody = materielsList.querySelector("tbody");
    const categories = (() => { try { return JSON.parse(materielsList.dataset.categories || "{}"); } catch { return {}; } })();
    const stateClass = (etat) => ({
      "En service": "state-service",
      "En réparation": "state-reparation",
      "Déclassé": "state-declasse",
    }[etat] || "");
    const fmtDate = (ymd) => {
      if (!ymd) return "—";
      const [y, m, d] = ymd.split("-");
      return `${d}/${m}/${y}`;
    };
    const escapeHtml = (s) => String(s ?? "").replace(/[&<>"']/g, c => ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c]));

    Store.getAdded("materiels").forEach(m => {
      // Filtres déjà appliqués côté PHP (q/categorie/etat) — on respecte les params ?etat= si présents
      const url = new URL(window.location.href);
      const fEtat = url.searchParams.get("etat");
      const slugMap = { service: "En service", reparation: "En réparation", declasse: "Déclassé" };
      const fEtatVal = slugMap[fEtat] || fEtat || "";
      if (fEtatVal && m.etat !== fEtatVal) return;
      const fCat = url.searchParams.get("categorie");
      if (fCat && String(m.categorie) !== String(fCat)) return;
      const fQ = (url.searchParams.get("q") || "").toLowerCase();
      if (fQ && !(m.reference + " " + m.designation).toLowerCase().includes(fQ)) return;

      const tr = document.createElement("tr");
      tr.dataset.rowId = m.id;
      tr.innerHTML = `
        <td><code class="text-muted">${escapeHtml(m.reference)}</code></td>
        <td class="fw-medium">${escapeHtml(m.designation)}</td>
        <td>${escapeHtml(categories[m.categorie] || "—")}</td>
        <td class="text-muted">${escapeHtml(fmtDate(m.date_achat))}</td>
        <td><span class="badge-state ${stateClass(m.etat)}">${escapeHtml(m.etat)}</span></td>
        <td><span class="text-muted">0</span></td>
        <td class="text-end">
          <div class="btn-group btn-group-sm">
            <span class="btn btn-outline-light disabled" title="Voir (à brancher)"><i data-lucide="eye" class="icon-sm"></i></span>
            <span class="btn btn-outline-light disabled" title="Modifier (à brancher)"><i data-lucide="pencil" class="icon-sm"></i></span>
            <button type="button" class="btn btn-outline-light text-danger" title="Supprimer"
                    data-confirm
                    data-confirm-title="Supprimer ce matériel ?"
                    data-confirm-message="Cette action est irréversible."
                    data-confirm-cta="Supprimer"
                    data-confirm-icon="trash-2"
                    data-confirm-variant="danger"
                    data-confirm-action="delete-row"
                    data-target-resource="materiels"
                    data-target-id="${escapeHtml(m.id)}"
                    data-target-label="${escapeHtml(m.reference)}">
              <i data-lucide="trash-2" class="icon-sm"></i>
            </button>
          </div>
        </td>`;
      // Retirer le placeholder "Aucun matériel" s'il existe
      const empty = tbody.querySelector("tr td[colspan]");
      if (empty) empty.parentElement.remove();
      tbody.insertBefore(tr, tbody.firstChild);
    });
    if (window.lucide) lucide.createIcons();
  }

  // Techniciens
  const techList = document.querySelector('[data-store-list="techniciens"]');
  if (techList) {
    const tbody = techList.querySelector("tbody");
    const initials = (p, n) => ((p?.[0] || "") + (n?.[0] || "")).toUpperCase();
    const escapeHtml = (s) => String(s ?? "").replace(/[&<>"']/g, c => ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c]));

    Store.getAdded("techniciens").forEach(t => {
      const tr = document.createElement("tr");
      tr.dataset.rowId = t.id;
      tr.innerHTML = `
        <td>
          <div class="d-flex align-items-center gap-2">
            <div class="d-inline-flex align-items-center justify-content-center"
                 style="width:36px;height:36px;border:1px solid var(--asinco-border);border-radius:8px;font-weight:700;font-size:0.825rem;color:var(--asinco-text);background:var(--asinco-surface-2);">
              ${escapeHtml(initials(t.prenom, t.nom))}
            </div>
            <div>
              <div class="fw-medium">${escapeHtml((t.prenom || "") + " " + (t.nom || ""))}</div>
              <div class="text-muted small">Nouveau · ${escapeHtml(t.email || "—")}</div>
            </div>
          </div>
        </td>
        <td><span class="badge-state">${escapeHtml(t.specialite || "—")}</span></td>
        <td>
          <div class="d-flex align-items-center gap-2" style="max-width:220px;">
            <div class="progress flex-grow-1" style="height: 6px; background: var(--asinco-surface-2);">
              <div class="progress-bar" role="progressbar" style="width: 0%; background: var(--asinco-accent);"></div>
            </div>
            <span class="text-muted small">0</span>
          </div>
        </td>
        <td class="text-end">
          <div class="btn-group btn-group-sm">
            <span class="btn btn-outline-light disabled" title="Modifier (à brancher)"><i data-lucide="pencil" class="icon-sm"></i></span>
            <button type="button" class="btn btn-outline-light text-danger" title="Supprimer"
                    data-confirm data-confirm-title="Supprimer ce technicien ?"
                    data-confirm-message="Cette action est irréversible."
                    data-confirm-cta="Supprimer" data-confirm-icon="trash-2" data-confirm-variant="danger"
                    data-confirm-action="delete-row" data-target-resource="techniciens"
                    data-target-id="${escapeHtml(t.id)}" data-target-label="${escapeHtml((t.prenom || "") + " " + (t.nom || ""))}">
              <i data-lucide="trash-2" class="icon-sm"></i>
            </button>
          </div>
        </td>`;
      tbody.insertBefore(tr, tbody.firstChild);
    });
    if (window.lucide) lucide.createIcons();
  }

  // ---------- Formulaires : interception et persistance ----------
  document.querySelectorAll("form[data-store-form]").forEach(form => {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      if (!form.checkValidity()) {
        form.classList.add("was-validated");
        form.reportValidity();
        return;
      }
      const resource = form.dataset.storeResource;
      const fd = new FormData(form);
      const item = Object.fromEntries(fd.entries());
      item.id = Store.nextId(resource);
      Store.addItem(resource, item);

      // Toast côté liste après redirection
      sessionStorage.setItem("asinco-flash", JSON.stringify({
        message: resource === "materiels" ? `Matériel « ${item.reference || ""} » créé.`
              : resource === "techniciens" ? `Technicien « ${(item.prenom || "") + " " + (item.nom || "")} » créé.`
              : "Élément créé.",
        title: "Création réussie",
      }));

      const redirect = form.dataset.redirect || "liste.php";
      window.location.href = redirect;
    });
  });

  // Flash toast après redirection (pattern post-redirect)
  const flash = sessionStorage.getItem("asinco-flash");
  if (flash) {
    sessionStorage.removeItem("asinco-flash");
    try {
      const f = JSON.parse(flash);
      setTimeout(() => toast(f.message, { title: f.title }), 100);
    } catch {}
  }

  // ---------- Profil : édition + synchro topbar ----------
  const profile = Store.ns("profile");
  if (!profile.name)  profile.name  = "Administrateur ASINCO";
  if (!profile.email) profile.email = "admin@asinco.bj";

  const syncProfile = () => {
    document.querySelectorAll("[data-profile-name]").forEach(el => el.textContent = profile.name.split(" ")[0] || "Admin");
    document.querySelectorAll("[data-profile-name-display]").forEach(el => el.textContent = profile.name);
    document.querySelectorAll("[data-profile-email-display]").forEach(el => el.textContent = profile.email);
  };
  syncProfile();

  document.querySelectorAll("[data-profile-edit]").forEach(btn => {
    btn.addEventListener("click", () => {
      const view = btn.closest("#profileCard").querySelector("[data-profile-view]");
      const form = btn.closest("#profileCard").querySelector("[data-profile-form]");
      form.querySelector("input[name='name']").value  = profile.name;
      form.querySelector("input[name='email']").value = profile.email;
      view.classList.add("d-none");
      form.classList.remove("d-none");
    });
  });
  document.querySelectorAll("[data-profile-cancel]").forEach(btn => {
    btn.addEventListener("click", () => {
      const card = btn.closest("#profileCard");
      card.querySelector("[data-profile-view]").classList.remove("d-none");
      card.querySelector("[data-profile-form]").classList.add("d-none");
    });
  });
  document.querySelectorAll("[data-profile-form]").forEach(form => {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      profile.name  = form.querySelector("input[name='name']").value.trim()  || profile.name;
      profile.email = form.querySelector("input[name='email']").value.trim() || profile.email;
      Store.save();
      syncProfile();
      const card = form.closest("#profileCard");
      card.querySelector("[data-profile-view]").classList.remove("d-none");
      card.querySelector("[data-profile-form]").classList.add("d-none");
      toast("Profil mis à jour.", { title: "Enregistré" });
    });
  });

  // ---------- Switches de préférences (data-pref) ----------
  document.querySelectorAll("[data-pref]").forEach(el => {
    const key = el.dataset.pref;
    const stored = Store.getPref(key, undefined);
    if (stored !== undefined && el.type === "checkbox") el.checked = !!stored;
    el.addEventListener("change", () => {
      const value = el.type === "checkbox" ? el.checked : el.value;
      Store.setPref(key, value);
      toast("Préférence enregistrée.", { title: "Paramètres", duration: 1500 });
    });
  });

  // ---------- Reveal animations (IntersectionObserver) ----------
  const reveals = document.querySelectorAll("[data-reveal]");
  if (reveals.length && "IntersectionObserver" in window) {
    const computeDelay = (el) => {
      const group = el.closest("[data-reveal-group]");
      if (!group) return 0;
      const peers = Array.from(group.querySelectorAll("[data-reveal]")).filter(p => p.closest("[data-reveal-group]") === group);
      const idx = peers.indexOf(el);
      return Math.max(0, idx) * 90;
    };
    const reveal = (el) => {
      el.style.transitionDelay = computeDelay(el) + "ms";
      el.classList.add("is-visible");
    };
    // Reveal immédiat pour les groupes marqués (hero)
    document.querySelectorAll("[data-reveal-immediate] [data-reveal]").forEach(reveal);

    const obs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          reveal(entry.target);
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: "0px 0px -6% 0px" });

    reveals.forEach(el => {
      if (el.classList.contains("is-visible")) return;
      obs.observe(el);
    });
  } else {
    reveals.forEach(el => el.classList.add("is-visible"));
  }
})();
