<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth.php';

// Assuming auth.php populates the session with user details
// including username and avatar URL. If not, you should modify your login process
// to store these values in $_SESSION.
// Example: $_SESSION['avatar_url'] = $user['avatar_url'];

$username = ucfirst($_SESSION['username'] ?? 'Guest');
$avatarUrl = $_SESSION['avatar_url'] ?? '/path/to/default/avatar.png'; // Provide a default avatar path
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="/assets/img/Quezon_City.svg.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.2.0/css/line.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.2.0/css/solid.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.2.0/css/thinline.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/modal-fix.css" rel="stylesheet">
    <title><?= $pageTitle ?? 'Local Government Unit 2' ?></title>
</head>

<body>
    <div class="blue col-12 fs-1 d-lg-flex d-md-flex d-none d-sm-block d-sm-none d-md-block d-md-none d-lg-block justify-content-center">
        <img class="logo col-12 " src="/assets/img/Quezon_City.svg.png" alt="Quezon City Logo">
    </div>

    <header class="header bg-light d-flex g-0 align-items-center col-md-12 col-lg-12 col-xl-12">
        <div class="burger-bg bg-danger position-relative">
            <button class="btn burger fs-1 mb-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><i class="uil uil-bars"></i></button>
        </div>
        <img class="qc-text" src="/assets/img/QC.png" alt="QC Text">
        <div class="title d-flex align-items-center justify-content-between">
            <p class="text-dark title mt-3 fs-md-5">LOCAL GOVERNMENT UNIT 2</p>
            <div class="profile dropdown">
                <button class="btn btn-light d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar-32">
                        <img src="<?= $avatarUrl ?>" alt="User Avatar">
                    </div>
                    <i class="fa-solid fa-caret-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="p-1 fw-normal"><a class="dropdown-item profile-link nav-link" href="/contents/profile/profile.php"><i class="fa-regular fa-user me-2"></i>Profile</a></li>
                    <li class="p-1 fw-normal"><a class="dropdown-item settings-link nav-link" href="/settings.php"><i class="fa-solid fa-gear me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="text-right"><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div id="backdrop" class="backdrop" aria-hidden="true"></div>

    <div class="wrapper" id="wrapper">
        <aside class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <?php
            // Define user roles and their accessible sections
            $userType = strtolower($_SESSION['user_type'] ?? '');
            $userAccess = [
                'records' => ['records'],
                'minutes' => ['minutes'],
                'agenda' => ['agenda'],
                'committee' => ['committee'],
                'journal' => ['journal'],
                'archive' => ['archive'],
                'research' => ['research'],
                'ordinance' => ['ordinance'],
                'hearing' => ['hearing'],
                'consult' => ['consult'],
                'admin' => ['all']
            ];

            $isAdmin = $userType === 'admin';

            $allSections = [
                'dashboard',
                'records',
                'minutes',
                'agenda',
                'committee',
                'journal',
                'archive',
                'research',
                'ordinance',
                'hearing',
                'consult'
            ];

            $allowedSections = $isAdmin ? $allSections : ($userAccess[$userType] ?? []);

            function canAccessSection($sectionId, $allowedSections, $isAdmin)
            {
                if ($sectionId === 'dashboard') {
                    return true;
                }
                return $isAdmin || in_array($sectionId, $allowedSections);
            }
            ?>
            <div class="offcanvas-header col-12 d-flex align-items-center p-1">
                <img class="side-logo col-12 d-lg-none" src="/assets/img/Quezon_City.svg.png" alt="Quezon City Logo">
                <button class="close" data-bs-dismiss="offcanvas"><i class="uil uil-list-ui-alt"></i></button>
            </div>
            <div class="sidebar-top pd">
                <div class="profile-pod">
                    <div class="text-center w-100">
                        <div class="avatar-64 mx-auto mb-3">
                            <img src="<?= $avatarUrl ?>" alt="User Avatar">
                        </div>
                        <div class="user-name">
                            <h5 class="fw-bold"><?= $username ?></h5>
                        </div>
                    </div>
                </div>
                <hr class="aside-hr me-4 ms-4 p-0">
            </div>

            <nav class="side-nav" id="sideNav">
                <?php if (canAccessSection('dashboard', $allowedSections, $isAdmin)): ?>
                    <div class="nav-group">
                        <a href="/dashboard.php" class="group-toggle no-caret" style="text-decoration: none;">
                            <span class="ico"><i class="fa-solid fa-gauge"></i></span>
                            Dashboard
                        </a>
                    </div>
                <?php endif; ?>

                <?php if (canAccessSection('ordinance', $allowedSections, $isAdmin)): ?>
                    <div class="nav-group">
                        <button class="group-toggle">
                            <span class="ico"><i class="fa-solid fa-gavel"></i></span>
                            Ordinance and Resolution
                            <i class="fa-solid fa-chevron-down caret"></i>
                        </button>
                        <ul class="sublist">
                            <li><a href="/contents/ordinance-resolution-tracking/draft-creation.php" class="nav-link">Draft Creation & Editing</a></li>
                            <li><a href="/contents/ordinance-resolution-tracking/sponsorship-management.php" class="nav-link">Sponsorship & Author Management</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (canAccessSection('minutes', $allowedSections, $isAdmin)): ?>
                    <div class="nav-group">
                        <button class="group-toggle">
                            <span class="ico"><i class="fa-solid fa-handshake-angle"></i></span>
                            Minutes Section
                            <i class="fa-solid fa-chevron-down caret"></i>
                        </button>
                        <ul class="sublist">
                            <li><a href="/contents/session-meeting-management/session-scheduling.php" class="nav-link">Session Scheduling and Notifications</a></li>
                            <li><a href="/contents/session-meeting-management/agenda-builder.php" class="nav-link">Agenda Builder</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (canAccessSection('records', $allowedSections, $isAdmin)): ?>
                    <div class="nav-group">
                        <button class="group-toggle">
                            <span class="ico"><i class="fa-solid fa-calendar-days"></i></span>
                            Agenda and Briefing
                            <i class="fa-solid fa-chevron-down caret"></i>
                        </button>
                        <ul class="sublist">
                            <li><a href="/contents/agenda-section/m3-notifications-viewer.php" class="nav-link">MFL Notifications</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (canAccessSection('committee', $allowedSections, $isAdmin)): ?>
                    <div class="nav-group">
                        <button class="group-toggle">
                            <span class="ico"><i class="fa-solid fa-users"></i></span>
                            Committee Management System
                            <i class="fa-solid fa-chevron-down caret"></i>
                        </button>
                        <ul class="sublist">
                            <li><a href="/contents/committee-management-system/placeholder.php?t=Committee%20Creation%20%26%20Membership" class="nav-link">Committee Creation & Membership</a></li>
                            <li><a href="/contents/committee-management-system/placeholder.php?t=Assignment%20of%20Legislative%20Items" class="nav-link">Assignment of Legislative Items</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (canAccessSection('journal', $allowedSections, $isAdmin)): ?>
                    <div class="nav-group">
                        <button class="group-toggle">
                            <span class="ico"><i class="fa-solid fa-check-to-slot"></i></span>
                            Committee Journal
                            <i class="fa-solid fa-chevron-down caret"></i>
                        </button>
                        <ul class="sublist">
                            <li><a href="/contents/voting-decision-making-system/placeholder.php?t=Roll%20Call%20Management" class="nav-link">Roll Call Management</a></li>
                            <li><a href="/contents/voting-decision-making-system/placeholder.php?t=Motion%20Creation%20%26%20Seconding" class="nav-link">Motion Creation & Seconding</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (canAccessSection('records', $allowedSections, $isAdmin)): ?>
                    <div class="nav-group">
                        <button class="group-toggle">
                            <span class="ico"><i class="fa-solid fa-folder-open"></i></span>
                            Records And Correspondence
                            <i class="fa-solid fa-chevron-down caret"></i>
                        </button>
                        <ul class="sublist">
                            <li><a href="/contents/records-and-correspondence/measure-docketing.php" class="nav-link">Measure Docketing</a></li>
                            <li><a href="/contents/records-and-correspondence/categorization-and-classification.php" class="nav-link">Categorization and Classification</a></li>
                            <li><a href="/contents/records-and-correspondence/document-tracking.php" class="nav-link">Document Tracking</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (canAccessSection('hearing', $allowedSections, $isAdmin)): ?>
                    <div class="nav-group">
                        <button class="group-toggle">
                            <span class="ico"><i class="fa-solid fa-microphone-lines"></i></span>
                            Committee Hearing
                            <i class="fa-solid fa-chevron-down caret"></i>
                        </button>
                        <ul class="sublist">
                            <li><a href="/contents/public-hearing-management/placeholder.php?t=Hearing%20Schedule" class="nav-link">Hearing Schedule</a></li>
                            <li><a href="/contents/public-hearing-management/placeholder.php?t=Speaker/Participant%20Registration" class="nav-link">Speaker/Participant Registration</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (canAccessSection('archive', $allowedSections, $isAdmin)): ?>
                    <div class="nav-group">
                        <button class="group-toggle">
                            <span class="ico"><i class="fa-solid fa-box-archive"></i></span>
                            Archive Section
                            <i class="fa-solid fa-chevron-down caret"></i>
                        </button>
                        <ul class="sublist">
                            <li><a href="/contents/legislative-archives/placeholder.php?t=Enacted%20Ordinances%20Archive" class="nav-link">Enacted Ordinances Archive</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (canAccessSection('research', $allowedSections, $isAdmin)): ?>
                    <div class="nav-group">
                        <button class="group-toggle">
                            <span class="ico"><i class="fa-solid fa-magnifying-glass-chart"></i></span>
                            Research Section
                            <i class="fa-solid fa-chevron-down caret"></i>
                        </button>
                        <ul class="sublist">
                            <li><a href="/contents/legislative-research-section/research_dashboard.php" class="nav-link">Research Dashboard</a></li>
                            <li><a href="/contents/legislative-research-section/draftmeasurestask.php" class="nav-link">Draft Measures Task</a></li>
                            <li><a href="/contents/legislative-research-section/similarmeasuretool.php" class="nav-link">Similarity Checking Tool (Pending Measures)</a></li>
                            <li><a href="/contents/legislative-research-section/citationcheckingtool.php" class="nav-link">Citation Checking Tool</a></li>
                            <li><a href="/contents/legislative-research-section/measurecomparisontool.php" class="nav-link">Measure Comparison Tool</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (canAccessSection('consult', $allowedSections, $isAdmin)): ?>
                    <div class="nav-group">
                        <button class="group-toggle">
                            <span class="ico"><i class="fa-solid fa-comments"></i></span>
                            Public Consultation Management
                            <i class="fa-solid fa-chevron-down caret"></i>
                        </button>
                        <ul class="sublist">
                            <li><a href="/contents/public-consultation-management/placeholder.php?t=Public%20Feedback%20Portal" class="nav-link">Public Feedback Portal</a></li>
                            <li><a href="/contents/public-consultation-management/placeholder.php?t=Survey%20Builder" class="nav-link">Survey Builder</a></li>
                            <li><a href="/contents/public-consultation-management/placeholder.php?t=Issue%20Mapping" class="nav-link">Issue Mapping</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </nav>
        </aside>

        <main class="content" id="content">